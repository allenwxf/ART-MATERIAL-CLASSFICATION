from PIL import Image
import datetime, os
from fr_utils import *
from inception_blocks import *
from tensorflow.python.keras import backend as K
K.set_image_data_format('channels_last')


## start
start = datetime.datetime.now()

resizeShape = (96, 96)
artImgDir = "images/art/"
targetImgDir = "images/target/"

FRmodelPath = "model/frmodel.h5"
imgEncodingPath = "dataset/imgencoding.h5"

if os.path.exists(FRmodelPath):
    FRmodel = keras.models.load_model(FRmodelPath, compile=False)
else:
    # FRmodel = artMaterialVeriModel(input_shape=(3, 96, 96))
    FRmodel = artMaterialVeriModel(input_shape=(96, 96, 3))
    FRmodel.save(FRmodelPath)

print("Total Params: ", FRmodel.count_params())

database = {}

files= os.listdir(artImgDir)

## end
end = datetime.datetime.now()
print ("TIME loading model: ", end-start)


## start
start = datetime.datetime.now()

savedEncodingh5 = h5py.File(imgEncodingPath,'a')
sekeys = list(savedEncodingh5.keys())

for file in files:
    if not os.path.isdir(file):
        if file in sekeys:
            imgencoding = savedEncodingh5[file][:]
        else:
            imgencoding = img_to_encoding(artImgDir + file, resizeShape, FRmodel)
            savedEncodingh5[file] = imgencoding
            # savedEncodingh5.create_dataset(file, data=imgencoding)
        print(imgencoding)
        database[file] = imgencoding
print(savedEncodingh5["B1_2i.png"], savedEncodingh5["B1_2i.png"][:])

savedEncodingh5.close()

## end
end = datetime.datetime.now()
print ("TIME loading dataset: ", end-start)

# GRADED FUNCTION: who_is_it
def who_is_it(targetImgDir, imagePath, file, db, resizeShape, model):
    # print("who_is_it: ", db["B1_2i.png"])
    """
    Implements face recognition for the happy house by finding who is the person on the image_path image.

    Arguments:
    image_path -- path to an image
    db -- database containing image encodings along with the name of the person on the image
    model -- your Inception model instance in Keras

    Returns:
    min_dist -- the minimum distance between image_path encoding and the encodings from the database
    identity -- string, the name prediction for the person on image_path
    """

    ## Step 1: Compute the target "encoding" for the image. Use img_to_encoding() see example above. ## (≈ 1 line)
    encoding = img_to_encoding(targetImgDir+file, resizeShape, model)

    ## Step 2: Find the closest encoding ##
    # Initialize "min_dist" to a large value, say 100 (≈1 line)
    min_dist = 100

    similarityArr = []
    # Loop over the database dictionary's names and encodings.
    for name in db:
        # if name == file:
        #     continue

        # Compute L2 distance between the target "encoding" and the current "emb" from the db. (≈ 1 line)
        dist = np.linalg.norm(encoding - db[name])

        dists = {"name": name, "dist": dist}
        similarityArr.append(dists)

        # If this distance is less than the min_dist, then set min_dist to dist, and identity to name. (≈ 3 lines)
        # if dist < min_dist:
        #     min_dist = dist
        #     identity = name


    def dist(s):
        return s['dist']

    similarityArr = sorted(similarityArr, key = dist)

    # print("similarityArr: ", similarityArr)
    # picNum = len(similarityArr)

    plt.figure(num=1, figsize=(10, 10))

    for key in range(10):
        plt.subplot(5, 2, key+1)
        plt.title('distance: ' + str(similarityArr[key]["dist"]))
        plt.imshow(Image.open(imagePath + similarityArr[key]["name"]))

    plt.show()

    # if min_dist > 0.7:
    #     print("Not in the database.")


targets = os.listdir(targetImgDir)

for fileKey in range(len(targets)):
    who_is_it(targetImgDir, artImgDir, targets[fileKey], database, resizeShape, FRmodel)
