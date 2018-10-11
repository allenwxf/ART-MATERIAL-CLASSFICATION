import numpy as np

tmp = [1,2,3,4,5,6]
tmp1 = np.array(tmp)
print(tmp1)
tmp1 = tmp1.tolist()
print(tmp1)

tmp2 = np.array([tmp])
print(tmp2)

tmp_1 = [1]
tmp3 = np.array(tmp_1).reshape(1, 1)
print(tmp3)
print(tmp3[0])