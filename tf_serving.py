import os, requests, json, h5py, cv2
import numpy as np
from flask import Flask, request
app = Flask(__name__)

tf_serving_api = "http://192.168.116.125:8501/v1/models/ArtMaterialVerification:predict"

resizeShape = (96, 96)
artImgDir = "images/art/"
targetImgDir = "images/target/"

imgEncodingPath = "dataset/imgencoding.h5"


@app.route('/', methods=['GET', 'POST'])
def index():
    savedEncodingh5 = h5py.File(imgEncodingPath, 'a')
    sekeys = list(savedEncodingh5.keys())

    database = {}
    files = os.listdir(artImgDir)
    for file in files:
        if not os.path.isdir(file):
            file = file.encode("utf-8", errors="surrogateescape").decode("utf-8")
            if file in sekeys:
                imgencoding = savedEncodingh5[file][:]
            else:
                imgencoding = get_img_feature(artImgDir + file)
                savedEncodingh5[file] = imgencoding
            database[file] = imgencoding
    savedEncodingh5.close()

    results = []
    targets = os.listdir(targetImgDir)
    for fileKey in range(len(targets)):
        file = targets[fileKey].encode("utf-8", errors="surrogateescape").decode("utf-8")
        res = get_art_distance(targetImgDir, file, database)
        results.append(res)

    return _ret(data={"similarities": results})




def get_img_feature(img_file):
    # img1 = cv2.imread(img_file, cv2.IMREAD_COLOR)
    img1 = cv2.imdecode(np.fromfile(img_file, dtype=np.uint8), cv2.IMREAD_COLOR)
    img2 = cv2.resize(img1, resizeShape, interpolation=cv2.INTER_CUBIC)
    img = img2[..., ::-1]
    # img = np.around(np.transpose(img, (2, 0, 1)) / 255.0, decimals=12)
    img = np.around(img / 255.0, decimals=12)
    img_array = np.array(img)
    payload = {
        "instances": [{'input_image': img_array.tolist()}]
    }

    r = requests.post(tf_serving_api, json=payload)
    rdict = json.loads(r.content.decode('utf-8'))
    return rdict['predictions']

def get_art_distance(targetImgDir, file, database):
    imgencoding = get_img_feature(targetImgDir+file)

    min_dist = 100
    similarityArr = []

    for name in database:
        dist = np.linalg.norm(imgencoding - database[name])
        dists = {"name": name, "dist": str(dist)}
        similarityArr.append(dists)
        if dist < min_dist:
            min_dist = dist

    def dist(s):
        return s['dist']

    similarityArr = sorted(similarityArr, key = dist)

    if min_dist > 0.7:
        print("Not in the database.")

    return {"target": file, "similarity": similarityArr}




def _ret(msg="", errcode=0, data={}):
    ret = {
        "msg": msg,
        "code": errcode,
        "data": data
    }
    return json.dumps(ret)