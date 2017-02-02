import ogr,csv,sys
import os

print ("The SHP file parent path, for example: \n folder 'A' contain 3 SHP file, just enter the folder 'A' path")
print ("Your current directory is : %s\n\n" % os.getcwd())
shppath = raw_input("Enter the SHP file folder path : ")


#put the file paths into a temporary lists
shpfiles = []
csvfiles = []

for filenames in os.listdir(shppath):
    if os.path.splitext(filenames)[1].lower() == '.shp':
        path = shppath + '/' + filenames
        csvpath = shppath + '/' + os.path.splitext(filenames)[0] + '.csv'
        shpfiles.append(path)
        csvfiles.append(csvpath)

print ("SHP FILES : ")
for name in shpfiles:
    print name

print ("CSV FILES : ")
for name in csvfiles:
    print name

#Open files
print (" >>> Starting the process of converting the SHP files into CSV files. \n\n\n It might take a long time to process this. Go outside and make yourself useful!\n")
for i in range (len(shpfiles)):
    csvfile=open(csvfiles[i],'wb')
    ds=ogr.Open(shpfiles[i])
    lyr=ds.GetLayer()

    #Get field names
    dfn=lyr.GetLayerDefn()
    nfields=dfn.GetFieldCount()
    fields=[]
    for i in range(nfields):
        fields.append(dfn.GetFieldDefn(i).GetName())
    fields.append('kmlgeometry')
    csvwriter = csv.DictWriter(csvfile, fields)
    try:csvwriter.writeheader() #python 2.7+
    except:csvfile.write(','.join(fields)+'\n')

    # Write attributes and kml out to csv
    for feat in lyr:
        attributes=feat.items()
        geom=feat.GetGeometryRef()
        attributes['kmlgeometry']=geom.ExportToKML()
        csvwriter.writerow(attributes)

    #clean up
    del csvwriter,lyr,ds
    csvfile.close()
