import torch
import sys
import io
import os
import cv2
<<<<<<< HEAD
import re
=======
>>>>>>> dc6086cca414cb56879b1d723b4a5480f6308fe4
import string
import numpy as np
import matplotlib.pyplot as plt
from google.cloud import vision

class LicencePlateDetect:
    def __init__(self) -> None:
        self.model = torch.hub.load('ultralytics/yolov5', 'custom', path='LP_yolov5n_best.pt')
<<<<<<< HEAD
        # self.model =  torch.hub.load('WongKinYiu/yolov7', 'custom', 'yolov7x_best.pt',
                        # force_reload=True, trust_repo=True)

=======
>>>>>>> dc6086cca414cb56879b1d723b4a5480f6308fe4
        pass

    def detect_and_crop(self, imgs_path, isMax=True, isBiggerBox=True):
        """
            :param imgs_path: list, images to be detected
            :param isMax: only return max mAP image resule
            :rtype: list, list
            :return: pl localization and cropped img file path
        """
        results = self.model(imgs_path)
        detect_path = "./detected"

        # return value
        boxes = []
        cropped_imgs = []
        max_index = 0
        max_map = 0

        if not os.path.isdir(detect_path):
            os.mkdir(detect_path)

        # crop_img
        for i in range(len(results)):
            result = results.xyxy[i]
            # print (f'{i}, {result}')
            # print (imgs_path[i])
            img = cv2.imread(imgs_path)
            basename = os.path.basename(imgs_path)
            file_name = os.path.splitext(basename)[0]

            for r in result:
                box = [int(b) for b in r[:4]]
                if isBiggerBox:
                    box[0]=max(0, box[0]-5)
                    box[1]=max(0, box[1]-5)
                    box[2]=min(img.shape[1], box[2]+5)
                    box[3]=min(img.shape[0], box[3]+5)
                    

                cropped = img[box[1]:box[3], box[0]:box[2]]

                save_path = f'{detect_path}/{file_name}_detected_{"_".join("%s" %b for b in box)}.jpg'
                # print (save_path)
                cv2.imwrite(save_path, cropped)
                boxes.append(box)
                cropped_imgs.append(save_path)

                if max_map < r[4]:
                    max_map = r[4]
                    max_index = len(cropped_imgs)-1
<<<<<<< HEAD
        if len(cropped_imgs) <= 0:
            return "null","null"
        
        if isMax:
            return boxes[max_index], cropped_imgs[max_index]
        
=======
                
        if isMax:
            return boxes[max_index], cropped_imgs[max_index]
>>>>>>> dc6086cca414cb56879b1d723b4a5480f6308fe4
        return boxes, cropped_imgs

def LP(imgs_path):
    lpd = LicencePlateDetect()
    boxes, cropped = lpd.detect_and_crop(imgs_path)

    return cropped

def grayImage(imgs_path):
    im = cv2.imread(imgs_path)
    im_gray = cv2.cvtColor(im, cv2.COLOR_BGR2GRAY)

    th, im_gray_th_otsu = cv2.threshold(im_gray, 128, 192, cv2.THRESH_OTSU)

    # print(th)
    # 117.0

    cv2.imwrite('opencv_th_otsu.jpg', im_gray_th_otsu)


def cloudVision():
    # Instantiates a client
    client = vision.ImageAnnotatorClient()

    # The name of the image file to annotate
    file_name = os.path.abspath('opencv_th_otsu.jpg')

    # Loads the image into memory
    with io.open(file_name, 'rb') as image_file:
        content = image_file.read()

    image = vision.Image(content=content)

    # Performs label detection on the image file
    response = client.text_detection(image=image)
    texts = response.text_annotations
#     print('Texts:')

#     for text in texts:
#         print('\n"{}"'.format(text.description))

#         vertices = (['({},{})'.format(vertex.x, vertex.y)
#                     for vertex in text.bounding_poly.vertices])

#         print('bounds: {}'.format(','.join(vertices)))

#     if response.error.message:
#         raise Exception(
#             '{}\nFor more info on error messages, check: '
#             'https://cloud.google.com/apis/design/errors'.format(
#                 response.error.message))
<<<<<<< HEAD
    if texts == []:
        print('')
        return
    text = texts[0].description.translate(str.maketrans({key: None for key in string.punctuation}))
    text = text.replace(' ', '')
    text = re.sub(r"[^A-Z0-9]+",'',text)
    print(text)
#     print(texts)
    
img_path = sys.argv[1]

cropped_img = LP(img_path)
if cropped_img == "null":
    print("")
    sys.exit(0)
=======

    text = texts[0].description.translate(str.maketrans({key: None for key in string.punctuation}))
    text = text.replace(' ', '')
    print(text)
img_path = sys.argv[1]
cropeed_img = ""
cropped_img = LP(img_path)
>>>>>>> dc6086cca414cb56879b1d723b4a5480f6308fe4
grayImage(cropped_img)
cloudVision()
