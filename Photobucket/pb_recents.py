import urllib
import urllib2
import os
import datetime

#This gives our baseline time
hTime = str(datetime.datetime.utcnow())
hTime = hTime[:hTime.find(':')]
#This value currently never changes so that it can run indefinitly.
rRepeat = True
#This is the opening and closing for the link HTML file.


def mHtmLink(HtmLink):
    openingLines = ['\n<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"', '\n        "http://www.w3.org/TR/html4/loose.dtd">', '\n<html lang="en">', '\n', '\n<head>']
    closingLines = ['\n<title>Photobucket Thumbs</title>', '\n</head>', '\n', '\n<body>', '\nLoading your Library','\n</body>', '\n</html>']
    if os.path.isfile(HtmLink)== False:
        myOutputFile = open(HtmLink, 'wb')
        myOutputFile.writelines(openingLines)
        myOutputFile.writelines('\n<meta HTTP-EQUIV="REFRESH" content="0; url='+LibFull+'">')
        myOutputFile.writelines(closingLines)
        myOutputFile.close()

while rRepeat == True:
    try:
        #This is the URL for the recents page. In theory you can use any page from recents but it doesnt matter that much.
        response = urllib2.urlopen("http://photobucket.com/recentuploads?page=1")
        http = response.read()
        http = http.replace("\/", "/")
        #This segment searches through the HTML we have read from Photobucket looking for images. If it doesnt find any more then it will
        #reread the page.
        while http.find("fullsizeUrl") >= 0:
            http = http[http.find("fullsizeUrl")+14:]
            end = http.find('","')
            hName = http[:end]
            http = http[end+3:]
            if hName != "":
                #This starts the parsing of the image url so we can give it an origional descriptive name so we know if a duplicate
                #has been found.
                startA = hName.find('albums') 
                fName = hName[startA+7:]
                fName = fName.replace('/', '')
                folderN1 = hName[7:hName.find(".")]
                folderN2 = hName[hName.find("albums")+7:]
                folderN2 = folderN2[:folderN2.find('/')]
                folderN3 = hName[hName.find("albums")+8+len(folderN2):]
                folderN3 = folderN3[:folderN3.find('/')]
                fName = folderN1+"--"+folderN3+"--"+fName
                htmlName = folderN1+"--"+folderN3+".html"
                
                LibFull = "http://"+folderN1+".photobucket.com/user/"+folderN3+"/library/?view=recent&page=1"
                #This checks the current time to verify if we need to move over to a different folder
                nTime = str(datetime.datetime.now())
                nTime = nTime[:nTime.find(':')]
                if nTime != hTime:
                    hTime = nTime
                    fPath = os.path.join(os.getcwd(), hTime)
                    if os.path.exists(fPath) == False:
                        os.makedirs(fPath)
                fNameB = fName
                fName = os.path.join(fPath, fName)
                
                if hName[:4] == "http":
                    try:
                        if os.path.isfile(fName) != True:
                            imgData = urllib2.urlopen(hName).read()
                            rName = fName.lower()
                            #I added this name filter to help weed out spammy ebay listing pics. This catches a lot but not all.
                            #To avoid accidentally deleting a win, they are sent to a specific Ebay folder)
                            if len(imgData) == 7883:
                                tos = os.path.join(os.getcwd(), "TOS")
                                if os.path.exists(tos) == False:
                                    os.makedirs(tos)
                                output = open(os.path.join(tos, fNameB), 'wb')
                                htmlName = os.path.join(tos, htmlName)
                                mHtmLink(htmlName)
                            elif rName.find("ebay") == -1:
                                if rName.find("facebook") == -1:
                                    if rName.find("snapsave") == -1:
                                        if rName.find("screenshot") == -1:
                                            if rName.find("snapschat") == -1:
                                                output = open(fName, 'wb')
                                                htmlName = os.path.join(fPath, htmlName)
                                                #This creates the link HTML file
                                                mHtmLink(htmlName)
                                            else:
                                                snapChat = os.path.join(os.getcwd(), "SnapChat")
                                                if os.path.exists(snapChat) == False:
                                                    os.makedirs(snapChat)
                                                output = open(os.path.join(snapChat, fNameB), 'wb')
                                                htmlName = os.path.join(snapChat, htmlName)
                                                #This creates the link HTML file
                                                mHtmLink(htmlName)
                                        else:
                                            screenShot = os.path.join(os.getcwd(), "Screenshot")
                                            if os.path.exists(screenShot) == False:
                                                os.makedirs(screenShot)
                                            output = open(os.path.join(screenShot, fNameB), 'wb')
                                            htmlName = os.path.join(screenShot, htmlName)
                                            #This creates the link HTML file
                                            mHtmLink(htmlName)
                                    else:
                                        snapSave = os.path.join(os.getcwd(), "SnapSave")
                                        if os.path.exists(snapSave) == False:
                                            os.makedirs(snapSave)
                                        output = open(os.path.join(snapSave, fNameB), 'wb')
                                        htmlName = os.path.join(snapSave, htmlName)
                                        #This creates the link HTML file
                                        mHtmLink(htmlName)
                                else:
                                    faceBook = os.path.join(os.getcwd(), "Facebook")
                                    if os.path.exists(faceBook) == False:
                                        os.makedirs(faceBook)
                                    output = open(os.path.join(faceBook, fNameB), 'wb')
                            else:
                                #This verifies that Ebay does exist in your folders.
                                eBay = os.path.join(os.getcwd(), "Ebay")
                                if os.path.exists(eBay) == False:
                                    os.makedirs(eBay)
                                output = open(os.path.join(eBay, fNameB), 'wb')
                            output.write(imgData)
                            output.close()
                            print fName
                    except:
                        #This exception occurs when the file has been found in the folder. This prevents a flooding of duplicate images
                        #or wasted time downloading one you already have.
                        print "Duplicate Image"
    except:
        #This is a simple restart in case of any issues. I have come in to find it not running and when checking the log I got errors
        #from HTTP access to simple timeout errors. This catches them all and restarts the application.
        print "Fatal Error, Restarting"
