import tensorflow as tf
import keras

# print(tf.__version__, keras.__version__)

amv_model_path = "model/frmodel.h5"
export_path = "model/ArtMaterialVerification/2"

model = tf.keras.models.load_model(amv_model_path)

with tf.keras.backend.get_session() as sess:
    tf.saved_model.simple_save(
        sess,
        export_path,
        inputs={'input_image': model.input},
        outputs={t.name:t for t in model.outputs}
    )
