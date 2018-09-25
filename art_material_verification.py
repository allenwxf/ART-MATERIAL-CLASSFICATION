import json, datetime, os
from PIL import Image
from fr_utils import *
from inception_blocks import *
import keras
from keras import backend as K
K.set_image_data_format('channels_last')

from flask import Flask, request
app = Flask(__name__)


resizeShape = (96, 96)
artImgDir = "images/art/"
targetImgDir = "images/target/"

FRmodelPath = "model/frmodel.h5"
imgEncodingPath = "dataset/imgencoding.h5"

# GRADED FUNCTION: who_is_it
def who_is_it(targetImgDir, file, database, resizeShape, model):
    encoding = img_to_encoding(targetImgDir+file, resizeShape, model)

    # Initialize "min_dist" to a large value, say 100 (≈1 line)
    min_dist = 100
    similarityArr = []

    for name in database:
        # Compute L2 distance between the target "encoding" and the current "emb" from the database. (≈ 1 line)
        dist = np.linalg.norm(encoding - database[name])
        dists = {"name": name, "dist": str(dist)}
        similarityArr.append(dists)

        # If this distance is less than the min_dist, then set min_dist to dist, and identity to name. (≈ 3 lines)
        if dist < min_dist:
            min_dist = dist

    def dist(s):
        return s['dist']

    similarityArr = sorted(similarityArr, key = dist)

    if min_dist > 0.7:
        print("Not in the database.")

    return {"target": file, "similarity": similarityArr}



@app.route('/', methods=['GET', 'POST'])
def index():
    if os.path.exists(FRmodelPath):
        FRmodel = keras.models.load_model(FRmodelPath, compile=False)
    else:
        FRmodel = artMaterialVeriModel(input_shape=(96, 96, 3))
        FRmodel.save(FRmodelPath)
    print("Total Params:", FRmodel.count_params())

    savedEncodingh5 = h5py.File(imgEncodingPath, 'a')
    sekeys = list(savedEncodingh5.keys())

    database = {}
    files = os.listdir(artImgDir)
    for file in files:
        if not os.path.isdir(file):
            if file in sekeys:
                imgencoding = savedEncodingh5[file][:]
            else:
                imgencoding = img_to_encoding(artImgDir + file, resizeShape, FRmodel)
                savedEncodingh5[file] = imgencoding
            database[file] = imgencoding
    savedEncodingh5.close()

    results = []
    targets = os.listdir(targetImgDir)
    for fileKey in range(len(targets)):
        res = who_is_it(targetImgDir, targets[fileKey], database, resizeShape, FRmodel)
        results.append(res)

    return _ret(data={"similarities": results})


def _ret(msg="", errcode=0, data={}):
    ret = {
        "msg": msg,
        "code": errcode,
        "data": data
    }
    return json.dumps(ret)