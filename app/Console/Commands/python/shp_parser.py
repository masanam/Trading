import os
import ogr, osr, csv, sys, json

# FLIP THE COORDINATES FORMAT INTO LAT LONG
def flip(g):
    geo = json.loads(g)
    new_coor = []
    if geo['type'] == 'MultiPolygon' :
        for coor in geo['coordinates'][0][0]:
            coor[0], coor[1] = coor[1], coor[0]
            new_coor.append(coor)
    else:
        for coor in geo['coordinates'][0]:
            coor[0], coor[1] = coor[1], coor[0]
            new_coor.append(coor)
    geo['coordinates'] = new_coor
    return geo

shppath = sys.argv[1]
try:
    os.mkdir(shppath + 'csv/')
except:
    print ('csv folder is existed')
    
shpfiles = []
csvfiles = []

for filenames in os.listdir(shppath):
    if os.path.splitext(filenames)[1].lower() == '.shp':
        path = shppath + '/' + filenames
        csvpath = shppath + 'csv/' + os.path.splitext(filenames)[0] + '.csv'
        shpfiles.append(path)
        csvfiles.append(csvpath)

# SHOW THE SHP FILES THAT WILL BE PROCESSED
print ("SHP FILES : ")
for name in shpfiles:
    print name

# SHOW THE CSV FILES THAT WILL BE MADE
print ("CSV FILES : ")
for name in csvfiles:
    print name

#Open files
print (" >>> Starting the process of converting the SHP files into CSV files. \n\n It might take a long time to process this.\nGo outside and go to gym!\nActually don't it won't take that much of a time\n")
corrupt_files = []
for i in range (len(shpfiles)):
    csvfile=open(csvfiles[i],'wb')
    ds=ogr.Open(shpfiles[i])
    lyr=ds.GetLayer()

    '''
        Line 54-63 and 80 should be uncommented if we need to adjust the EPSG format.
        For now, it's not that important.
    '''

    # # input SpatialReference
    # inSpatialRef = osr.SpatialReference()
    # inSpatialRef.ImportFromEPSG(2927)
    #
    # # output SpatialReference
    # outSpatialRef = osr.SpatialReference()
    # outSpatialRef.ImportFromEPSG(4326)

    # # create the CoordinateTransformation
    # coordTrans = osr.CoordinateTransformation(inSpatialRef, outSpatialRef)

    #Get field names
    dfn=lyr.GetLayerDefn()
    nfields=dfn.GetFieldCount()
    fields=[]
    for i in range(nfields):
        fields.append(dfn.GetFieldDefn(i).GetName())
    #ADD NEW NAME FOR THE GEOMETRY
    fields.append('geometry')
    csvwriter = csv.DictWriter(csvfile, fields)
    try:csvwriter.writeheader() #python 2.7+
    except:csvfile.write(','.join(fields)+'\n')

    # Write attributes and kml out to csv
    for feat in lyr:
        attributes=feat.items()
        geom=feat.GetGeometryRef()
        # geom.Transform(coordTrans)
        try:
            attributes['geometry']=geom.ExportToJson()
            attributes['geometry'] = flip(attributes['geometry'])
        except:corrupt_files.append(shpfiles[0])
        csvwriter.writerow(attributes)

    #clean up
    del csvwriter,lyr,ds
    csvfile.close()

print ("\n >>> >>>> IT'S DONE! GO CREATE A GREAT APPLICATION, MATE <<<< <<<\n")
print ("The csv files are saved in the same directory as the shp files\n")
print ("PS: ANY QUESTION OR PROBLEM REGARDING THE CODE CAN BE DIRECTED TO ARYO PRADIPTA GEMA")
