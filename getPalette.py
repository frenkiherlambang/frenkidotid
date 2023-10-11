from PIL import Image
img Image.open("l.jpg")
import numpy
import matplotlib.pyplot as plt

import matplotlib. image as mpimg
image = mpimg.imread( 'I. jpg')
w, h, d = tuple (image.shape)
pixels
= numpy.reshape(image, (w * h
from sklearn.cluster import Weans
n colors = 10
model= KMeans(n_c1usters=n_c010rs, random_state=42) .fit (pixels)
= numpy.uint8(mode1 .cluster_centers_)
palette
def g, b):
    return • -format(r, g, b)
colors
for i in palette:
Ind = '3
rgb
for e in i:
if ind 2
rgb - rgb + str(e)
rgbl = rgb.split(",")
colors. int(rgbl [0] ) , int( rgbl[l]) , int( rgb1[2] ) ) )
rgb
else:
rgb = rgb + str(e) + "
ind ind + 1
print (colors)
plt. imshow( [palette])
plt. show()
