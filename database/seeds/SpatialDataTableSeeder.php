<?php

use Illuminate\Database\Seeder;
use App\Model\SpatialData;

class SpatialDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpatialData::create([
            'name'=> 'Sungai Multi Poly',
            'restricted_area'=> '12947812382132',
            'type'=> 'HTI',
            'desc'=> 'data HTI terjadi',
            'created_by'=> 1,
			'polygon' => DB::raw("GeomFromText('MultiPolygon(((-1.616370229185304 122.06281392665862,-1.6142618541833404 122.06148192665738,-1.6124338541816379 122.06006242665605,-1.6087869791782414 122.05716767665335,-1.6067961041763874 122.05555230165186,-1.6035746041733872 122.05293442664941,-1.6018551041717857 122.05149330164807,-1.5992939791694005 122.04899492664575,-1.594361729164807 122.04421492664129,-1.5907962291614863 122.04126292663854,-1.5856832291567244 122.03705417663463,-1.5841088541552582 122.03610555163374,-1.5768066041484574 122.03181330162974,-1.5741193541459548 122.03034267662838,-1.5725089791444549 122.029931926628,-1.5711247291431658 122.0296248016277,-1.568103354140352 122.02947905162758,-1.5673707291396697 122.02953042662762,-1.565055104137513 122.02980117662787,-1.5627123541353312 122.03002542662807,-1.5540914791273024 122.02995630162802,-1.5473702291210427 122.0298303016279,-1.5434443541173863 122.03000967662807,-1.5361534791105962 122.03013280162818,-1.5333402291079763 122.03020517662824,-1.531929104106662 122.03043592662846,-1.5294597291043623 122.03081892662881,-1.527216479102273 122.03110117662908,-1.526637604101734 122.03125780162922,-1.525353354100538 122.0317635516297,-1.51719522909294 122.03476230163248,-1.5110088540871784 122.0371333016347,-1.5097516040860075 122.03743355163498,-1.5059978540825116 122.03835730163584,-1.501945854078738 122.0393934266368,-1.5009779790778366 122.03953592663693,-1.5000009790769266 122.03961980163702,-1.4972607290743745 122.04100980163831,-1.4963923540735657 122.04126930163855,-1.4952798540725298 122.04137667663865,-1.4945108540718135 122.04139067663866,-1.4939048540712492 122.04146517663874,-1.4929551040703646 122.04171717663897,-1.4922857290697413 122.04179242663903,-1.4913902290689072 122.04182767663907,-1.4904039790679888 122.0413326766386,-1.4887209790664213 122.04022355163758,-1.4867572290645925 122.03870005163616,-1.4841782290621905 122.03651592663412,-1.4827212290608336 122.03537505163305,-1.4809928540592239 122.03365530163146,-1.4794541040577909 122.03164080162958,-1.4788928540572681 122.0306954266287,-1.4783768540567876 122.02997867662803,-1.477879229056324 122.0295139266276,-1.4751102290537452 122.02733917662557,-1.4747209790533828 122.02677030162505,-1.4743949790530793 122.02610980162443,-1.4739149790526322 122.0247986766232,-1.4737607290524886 122.02379392662228,-1.4730723540518473 122.02170805162034,-1.4719492290508014 122.01832155161718,-1.471225104050127 122.01753705161644,-1.470799854049731 122.01714005161608,-1.4701302290491074 122.0166414266156,-1.4695238540485427 122.01621117661522,-1.4678591040469922 122.01523955161431,-1.4656786040449614 122.0144756766136,-1.4631093540425686 122.01376030161293,-1.4607299790403527 122.01322642661243,-1.4588753540386254 122.01281455161205,-1.456333354036258 122.01251042661177,-1.454098979034177 122.0126605516119,-1.4514308540316923 122.01329442661249,-1.4492963540297044 122.01424530161339,-1.4477771040282894 122.0152374266143,-1.446520479027119 122.017052926616,-1.4455354790262016 122.01911680161791,-1.4447764790254949 122.02129480161994,-1.4443526040251 122.02421430162266,-1.4439013540246797 122.02666555162494,-1.443867229024648 122.03149355162944,-1.4436336040244304 122.03506442663277,-1.4437976040245832 122.03802680163552,-1.443499979024306 122.03999742663737,-1.4428497290237003 122.0426096766398,-1.4423171040232043 122.04482180164186,-1.44108822902206 122.04828505164508,-1.4394801040205623 122.05341067664986,-1.439064354020175 122.05419117665059,-1.4379613540191478 122.05576542665204,-1.4367949790180614 122.05672230165294,-1.4345156040159386 122.05734230165352,-1.4339456040154077 122.05718530165338,-1.432425479013992 122.0562439266525,-1.4307693540124498 122.05454830165091,-1.4287154790105367 122.05364505165008,-1.426336104008321 122.05290280164938,-1.423848229006004 122.05245955164897,-1.4218219790041167 122.05240205164891,-1.4195426040019938 122.05279330164929,-1.416837978999475 122.05341542664986,-1.414766728997546 122.05405617665046,-1.4125598539954907 122.05472117665107,-1.410271103993359 122.05465305165102,-1.4082263539914548 122.05365805165009,-1.406515978989862 122.0520543016486,-1.40508572898853 122.04952205164624,-1.4041982289877033 122.04738642664425,-1.4032747289868432 122.04552630164251,-1.4019353539855959 122.04390930164101,-1.3999357289837335 122.04301680164018,-1.39564747897974 122.04176980163902,-1.3851891039699997 122.03872630163617,-1.376250603961675 122.03615480163378,-1.367854853953856 122.03347792663129,-1.363738353950022 122.03212680163003,-1.3615128539479495 122.0316584266296,-1.3592148539458093 122.03072105162873,-1.3556499789424894 122.02882880162696,-1.3543196039412502 122.02745217662569,-1.3532694789402724 122.02551330162387,-1.3518204789389228 122.02119505161986,-1.350932853938096 122.01850005161734,-1.3500546039372783 122.01657042661554,-1.3482802289356257 122.01299967661222,-1.3471577289345802 122.01124280161058,-1.3451759789327347 122.00942380160889,-1.3439633539316054 122.00838880160792,-1.342723978930451 122.0082461766078,-1.3420456039298192 122.0082501766078,-1.3414486039292632 122.00829880160785,-1.340761103928623 122.008474426608,-1.3401279789280334 122.00861555160814,-1.3395219789274688 122.00872142660823,-1.616370229185304 122.06281392665862),(-1.3390426039270225 122.0087815516083,-1.338707978926711 122.00890967660841,-1.338029603926079 122.00902742660853,-1.3374506039255398 122.00892692660842,-1.3367448539248825 122.00866842660818,-1.3356409789238544 122.00817280160773,-1.3352879789235257 122.00752442660712,-1.3352877289235254 122.00673317660639,-1.3356853539238958 122.00594180160564,-1.3354859789237101 122.00485430160464,-1.334300478922606 122.00386530160371,-1.3331156039215024 122.00386505160371,-1.3307364789192868 122.0039640516038,-1.3303474789189245 122.0040626766039,-1.329352728917998 122.00455730160436,-1.3278694789166168 122.005249551605,-1.3266847289155133 122.00584280160555,-1.3251018539140391 122.00633780160602,-1.3239169789129357 122.0066344266063,-1.3226324789117394 122.00673342660639,-1.3216373539108126 122.0066341766063,-1.3213387289105345 122.00633780160602,-1.320054103909338 122.00604080160574,-1.3192672289086051 122.00633780160602,-1.3183719789077715 122.00683217660648,-1.3158487289054215 122.00828755160784,-1.3153512289049583 122.00854217660807,-1.314962353904596 122.00866992660819,-1.3145643539042253 122.00877542660828,-1.3141392289038294 122.00877717660829,-1.3138587289035681 122.00875555160827,-1.3135963539033237 122.00864255160816,-1.3134153539031552 122.0083578016079,-1.3133157289030624 122.00796930160753,-1.3132522289030033 122.00760355160719,-1.3131616039029188 122.00719217660681,-1.3131433539029018 122.00678067660643,-1.3130346039028007 122.00650667660618,-1.3128174789025984 122.006313301606,-1.3125279789023288 122.00614267660583,-1.3122023539020256 122.00609880160579,-1.3118767289017224 122.00618055160587,-1.311505978901377 122.00639942660608,-1.3094438538994564 122.00738330160699,-1.3066943538968958 122.0085766766081,-1.3044242288947816 122.00946692660894,-1.3030403538934927 122.0098623016093,-1.3017466038922878 122.00956555160903,-1.3007602288913693 122.00877467660828,-1.299972978890636 122.00778542660737,-1.2994751038901724 122.00699417660663,-1.298389353889161 122.00630180160599,-1.2972042288880574 122.0062028016059,-1.2957207288866759 122.0062028016059,-1.294237103885294 122.00580717660553,-1.2932413538843668 122.00442267660424,-1.292851853884004 122.00293905160285,-1.292652228883818 122.00125755160128,-1.2926336038838007 121.99993880160005,-1.292542603883716 121.99861255159882,-1.2924701038836484 121.99828067659851,-1.2923253538835136 121.99799442659824,-1.2921623538833618 121.99778642659805,-1.2918999788831176 121.99760242659788,-1.291610478882848 121.99757655159786,-1.2875671038790821 121.99792317659818,-1.2871329788786778 121.99805742659831,-1.2867892288783578 121.99813455159838,-1.2865087288780965 121.99808667659833,-1.2860654788776837 121.9979570515982,-1.2857216038773633 121.99774967659802,-1.2852059788768833 121.99737955159767,-1.2845091038762342 121.99681442659715,-1.2838486038756192 121.99614630159653,-1.2835408538753323 121.99579017659619,-1.2830791038749023 121.99489530159536,-1.2829343538747675 121.99464292659512,-1.2825271038743884 121.99421705159473,-1.2820384788739332 121.99390455159444,-1.2814051038733434 121.99354592659411,-1.2809618538729306 121.99324505159382,-1.280545603872543 121.99291092659351,-1.2802287288722478 121.99239430159304,-1.2800567288720877 121.99198180159264,-1.2799661038720032 121.99159255159229,-1.2799839788720198 121.9911695515919,-1.2801557288721799 121.99079442659153,-1.2805806038725756 121.9903290515911,-1.2808248538728029 121.99006805159087,-1.3390426039270225 122.0087815516083)))')"),
			'status' => 'a'
        ]);

        SpatialData::create([
            'name'=> 'Sungai Multi line',
            'restricted_area'=> '12947812382132',
            'type'=> 'HTI',
            'desc'=> 'data HTI terjadi',
            'created_by'=> 1,
            'polygon' => DB::raw("GeomFromText('MultiLineString((-1.616370229185304 122.06281392665862,-1.6142618541833404 122.06148192665738,-1.6124338541816379 122.06006242665605,-1.6087869791782414 122.05716767665335,-1.6067961041763874 122.05555230165186,-1.6035746041733872 122.05293442664941,-1.6018551041717857 122.05149330164807,-1.5992939791694005 122.04899492664575,-1.594361729164807 122.04421492664129,-1.5907962291614863 122.04126292663854,-1.5856832291567244 122.03705417663463,-1.5841088541552582 122.03610555163374,-1.5768066041484574 122.03181330162974,-1.5741193541459548 122.03034267662838,-1.5725089791444549 122.029931926628,-1.5711247291431658 122.0296248016277,-1.568103354140352 122.02947905162758,-1.5673707291396697 122.02953042662762,-1.565055104137513 122.02980117662787,-1.5627123541353312 122.03002542662807,-1.5540914791273024 122.02995630162802,-1.5473702291210427 122.0298303016279,-1.5434443541173863 122.03000967662807,-1.5361534791105962 122.03013280162818,-1.5333402291079763 122.03020517662824,-1.531929104106662 122.03043592662846,-1.5294597291043623 122.03081892662881,-1.527216479102273 122.03110117662908,-1.526637604101734 122.03125780162922,-1.525353354100538 122.0317635516297,-1.51719522909294 122.03476230163248,-1.5110088540871784 122.0371333016347,-1.5097516040860075 122.03743355163498,-1.5059978540825116 122.03835730163584,-1.501945854078738 122.0393934266368,-1.5009779790778366 122.03953592663693,-1.5000009790769266 122.03961980163702,-1.4972607290743745 122.04100980163831,-1.4963923540735657 122.04126930163855,-1.4952798540725298 122.04137667663865,-1.4945108540718135 122.04139067663866,-1.4939048540712492 122.04146517663874,-1.4929551040703646 122.04171717663897,-1.4922857290697413 122.04179242663903,-1.4913902290689072 122.04182767663907,-1.4904039790679888 122.0413326766386,-1.4887209790664213 122.04022355163758,-1.4867572290645925 122.03870005163616,-1.4841782290621905 122.03651592663412,-1.4827212290608336 122.03537505163305,-1.4809928540592239 122.03365530163146,-1.4794541040577909 122.03164080162958,-1.4788928540572681 122.0306954266287,-1.4783768540567876 122.02997867662803,-1.477879229056324 122.0295139266276,-1.4751102290537452 122.02733917662557,-1.4747209790533828 122.02677030162505,-1.4743949790530793 122.02610980162443,-1.4739149790526322 122.0247986766232,-1.4737607290524886 122.02379392662228,-1.4730723540518473 122.02170805162034,-1.4719492290508014 122.01832155161718,-1.471225104050127 122.01753705161644,-1.470799854049731 122.01714005161608,-1.4701302290491074 122.0166414266156,-1.4695238540485427 122.01621117661522,-1.4678591040469922 122.01523955161431,-1.4656786040449614 122.0144756766136,-1.4631093540425686 122.01376030161293,-1.4607299790403527 122.01322642661243,-1.4588753540386254 122.01281455161205,-1.456333354036258 122.01251042661177,-1.454098979034177 122.0126605516119,-1.4514308540316923 122.01329442661249,-1.4492963540297044 122.01424530161339,-1.4477771040282894 122.0152374266143,-1.446520479027119 122.017052926616,-1.4455354790262016 122.01911680161791,-1.4447764790254949 122.02129480161994,-1.4443526040251 122.02421430162266,-1.4439013540246797 122.02666555162494,-1.443867229024648 122.03149355162944,-1.4436336040244304 122.03506442663277,-1.4437976040245832 122.03802680163552,-1.443499979024306 122.03999742663737,-1.4428497290237003 122.0426096766398,-1.4423171040232043 122.04482180164186,-1.44108822902206 122.04828505164508,-1.4394801040205623 122.05341067664986,-1.439064354020175 122.05419117665059,-1.4379613540191478 122.05576542665204,-1.4367949790180614 122.05672230165294,-1.4345156040159386 122.05734230165352,-1.4339456040154077 122.05718530165338,-1.432425479013992 122.0562439266525,-1.4307693540124498 122.05454830165091,-1.4287154790105367 122.05364505165008,-1.426336104008321 122.05290280164938,-1.423848229006004 122.05245955164897,-1.4218219790041167 122.05240205164891,-1.4195426040019938 122.05279330164929,-1.416837978999475 122.05341542664986,-1.414766728997546 122.05405617665046,-1.4125598539954907 122.05472117665107,-1.410271103993359 122.05465305165102,-1.4082263539914548 122.05365805165009,-1.406515978989862 122.0520543016486,-1.40508572898853 122.04952205164624,-1.4041982289877033 122.04738642664425,-1.4032747289868432 122.04552630164251,-1.4019353539855959 122.04390930164101,-1.3999357289837335 122.04301680164018,-1.39564747897974 122.04176980163902,-1.3851891039699997 122.03872630163617,-1.376250603961675 122.03615480163378,-1.367854853953856 122.03347792663129,-1.363738353950022 122.03212680163003,-1.3615128539479495 122.0316584266296,-1.3592148539458093 122.03072105162873,-1.3556499789424894 122.02882880162696,-1.3543196039412502 122.02745217662569,-1.3532694789402724 122.02551330162387,-1.3518204789389228 122.02119505161986,-1.350932853938096 122.01850005161734,-1.3500546039372783 122.01657042661554,-1.3482802289356257 122.01299967661222,-1.3471577289345802 122.01124280161058,-1.3451759789327347 122.00942380160889,-1.3439633539316054 122.00838880160792,-1.342723978930451 122.0082461766078,-1.3420456039298192 122.0082501766078,-1.3414486039292632 122.00829880160785,-1.340761103928623 122.008474426608,-1.3401279789280334 122.00861555160814,-1.3395219789274688 122.00872142660823),(-1.3390426039270225 122.0087815516083,-1.338707978926711 122.00890967660841,-1.338029603926079 122.00902742660853,-1.3374506039255398 122.00892692660842,-1.3367448539248825 122.00866842660818,-1.3356409789238544 122.00817280160773,-1.3352879789235257 122.00752442660712,-1.3352877289235254 122.00673317660639,-1.3356853539238958 122.00594180160564,-1.3354859789237101 122.00485430160464,-1.334300478922606 122.00386530160371,-1.3331156039215024 122.00386505160371,-1.3307364789192868 122.0039640516038,-1.3303474789189245 122.0040626766039,-1.329352728917998 122.00455730160436,-1.3278694789166168 122.005249551605,-1.3266847289155133 122.00584280160555,-1.3251018539140391 122.00633780160602,-1.3239169789129357 122.0066344266063,-1.3226324789117394 122.00673342660639,-1.3216373539108126 122.0066341766063,-1.3213387289105345 122.00633780160602,-1.320054103909338 122.00604080160574,-1.3192672289086051 122.00633780160602,-1.3183719789077715 122.00683217660648,-1.3158487289054215 122.00828755160784,-1.3153512289049583 122.00854217660807,-1.314962353904596 122.00866992660819,-1.3145643539042253 122.00877542660828,-1.3141392289038294 122.00877717660829,-1.3138587289035681 122.00875555160827,-1.3135963539033237 122.00864255160816,-1.3134153539031552 122.0083578016079,-1.3133157289030624 122.00796930160753,-1.3132522289030033 122.00760355160719,-1.3131616039029188 122.00719217660681,-1.3131433539029018 122.00678067660643,-1.3130346039028007 122.00650667660618,-1.3128174789025984 122.006313301606,-1.3125279789023288 122.00614267660583,-1.3122023539020256 122.00609880160579,-1.3118767289017224 122.00618055160587,-1.311505978901377 122.00639942660608,-1.3094438538994564 122.00738330160699,-1.3066943538968958 122.0085766766081,-1.3044242288947816 122.00946692660894,-1.3030403538934927 122.0098623016093,-1.3017466038922878 122.00956555160903,-1.3007602288913693 122.00877467660828,-1.299972978890636 122.00778542660737,-1.2994751038901724 122.00699417660663,-1.298389353889161 122.00630180160599,-1.2972042288880574 122.0062028016059,-1.2957207288866759 122.0062028016059,-1.294237103885294 122.00580717660553,-1.2932413538843668 122.00442267660424,-1.292851853884004 122.00293905160285,-1.292652228883818 122.00125755160128,-1.2926336038838007 121.99993880160005,-1.292542603883716 121.99861255159882,-1.2924701038836484 121.99828067659851,-1.2923253538835136 121.99799442659824,-1.2921623538833618 121.99778642659805,-1.2918999788831176 121.99760242659788,-1.291610478882848 121.99757655159786,-1.2875671038790821 121.99792317659818,-1.2871329788786778 121.99805742659831,-1.2867892288783578 121.99813455159838,-1.2865087288780965 121.99808667659833,-1.2860654788776837 121.9979570515982,-1.2857216038773633 121.99774967659802,-1.2852059788768833 121.99737955159767,-1.2845091038762342 121.99681442659715,-1.2838486038756192 121.99614630159653,-1.2835408538753323 121.99579017659619,-1.2830791038749023 121.99489530159536,-1.2829343538747675 121.99464292659512,-1.2825271038743884 121.99421705159473,-1.2820384788739332 121.99390455159444,-1.2814051038733434 121.99354592659411,-1.2809618538729306 121.99324505159382,-1.280545603872543 121.99291092659351,-1.2802287288722478 121.99239430159304,-1.2800567288720877 121.99198180159264,-1.2799661038720032 121.99159255159229,-1.2799839788720198 121.9911695515919,-1.2801557288721799 121.99079442659153,-1.2805806038725756 121.9903290515911,-1.2808248538728029 121.99006805159087))')"),
            'status' => 'a'
        ]);

        SpatialData::create([
            'name'=> 'Sungai Single Line',
            'restricted_area'=> '12947812382132',
            'type'=> 'HTI',
            'desc'=> 'data HTI terjadi',
            'created_by'=> 1,
            'polygon' => DB::raw("GeomFromText('LineString(-1.616370229185304 122.06281392665862,-1.6142618541833404 122.06148192665738,-1.6124338541816379 122.06006242665605,-1.6087869791782414 122.05716767665335,-1.6067961041763874 122.05555230165186,-1.6035746041733872 122.05293442664941,-1.6018551041717857 122.05149330164807,-1.5992939791694005 122.04899492664575,-1.594361729164807 122.04421492664129,-1.5907962291614863 122.04126292663854,-1.5856832291567244 122.03705417663463,-1.5841088541552582 122.03610555163374,-1.5768066041484574 122.03181330162974,-1.5741193541459548 122.03034267662838,-1.5725089791444549 122.029931926628,-1.5711247291431658 122.0296248016277,-1.568103354140352 122.02947905162758,-1.5673707291396697 122.02953042662762,-1.565055104137513 122.02980117662787,-1.5627123541353312 122.03002542662807,-1.5540914791273024 122.02995630162802,-1.5473702291210427 122.0298303016279,-1.5434443541173863 122.03000967662807,-1.5361534791105962 122.03013280162818,-1.5333402291079763 122.03020517662824,-1.531929104106662 122.03043592662846,-1.5294597291043623 122.03081892662881,-1.527216479102273 122.03110117662908,-1.526637604101734 122.03125780162922,-1.525353354100538 122.0317635516297,-1.51719522909294 122.03476230163248,-1.5110088540871784 122.0371333016347,-1.5097516040860075 122.03743355163498,-1.5059978540825116 122.03835730163584,-1.501945854078738 122.0393934266368,-1.5009779790778366 122.03953592663693,-1.5000009790769266 122.03961980163702,-1.4972607290743745 122.04100980163831,-1.4963923540735657 122.04126930163855,-1.4952798540725298 122.04137667663865,-1.4945108540718135 122.04139067663866,-1.4939048540712492 122.04146517663874,-1.4929551040703646 122.04171717663897,-1.4922857290697413 122.04179242663903,-1.4913902290689072 122.04182767663907,-1.4904039790679888 122.0413326766386,-1.4887209790664213 122.04022355163758,-1.4867572290645925 122.03870005163616,-1.4841782290621905 122.03651592663412,-1.4827212290608336 122.03537505163305,-1.4809928540592239 122.03365530163146,-1.4794541040577909 122.03164080162958,-1.4788928540572681 122.0306954266287,-1.4783768540567876 122.02997867662803,-1.477879229056324 122.0295139266276,-1.4751102290537452 122.02733917662557,-1.4747209790533828 122.02677030162505,-1.4743949790530793 122.02610980162443,-1.4739149790526322 122.0247986766232,-1.4737607290524886 122.02379392662228,-1.4730723540518473 122.02170805162034,-1.4719492290508014 122.01832155161718,-1.471225104050127 122.01753705161644,-1.470799854049731 122.01714005161608,-1.4701302290491074 122.0166414266156,-1.4695238540485427 122.01621117661522,-1.4678591040469922 122.01523955161431,-1.4656786040449614 122.0144756766136,-1.4631093540425686 122.01376030161293,-1.4607299790403527 122.01322642661243,-1.4588753540386254 122.01281455161205,-1.456333354036258 122.01251042661177,-1.454098979034177 122.0126605516119,-1.4514308540316923 122.01329442661249,-1.4492963540297044 122.01424530161339,-1.4477771040282894 122.0152374266143,-1.446520479027119 122.017052926616,-1.4455354790262016 122.01911680161791,-1.4447764790254949 122.02129480161994,-1.4443526040251 122.02421430162266,-1.4439013540246797 122.02666555162494,-1.443867229024648 122.03149355162944,-1.4436336040244304 122.03506442663277,-1.4437976040245832 122.03802680163552,-1.443499979024306 122.03999742663737,-1.4428497290237003 122.0426096766398,-1.4423171040232043 122.04482180164186,-1.44108822902206 122.04828505164508,-1.4394801040205623 122.05341067664986,-1.439064354020175 122.05419117665059,-1.4379613540191478 122.05576542665204,-1.4367949790180614 122.05672230165294,-1.4345156040159386 122.05734230165352,-1.4339456040154077 122.05718530165338,-1.432425479013992 122.0562439266525,-1.4307693540124498 122.05454830165091,-1.4287154790105367 122.05364505165008,-1.426336104008321 122.05290280164938,-1.423848229006004 122.05245955164897,-1.4218219790041167 122.05240205164891,-1.4195426040019938 122.05279330164929,-1.416837978999475 122.05341542664986,-1.414766728997546 122.05405617665046,-1.4125598539954907 122.05472117665107,-1.410271103993359 122.05465305165102,-1.4082263539914548 122.05365805165009,-1.406515978989862 122.0520543016486,-1.40508572898853 122.04952205164624,-1.4041982289877033 122.04738642664425,-1.4032747289868432 122.04552630164251,-1.4019353539855959 122.04390930164101,-1.3999357289837335 122.04301680164018,-1.39564747897974 122.04176980163902,-1.3851891039699997 122.03872630163617,-1.376250603961675 122.03615480163378,-1.367854853953856 122.03347792663129,-1.363738353950022 122.03212680163003,-1.3615128539479495 122.0316584266296,-1.3592148539458093 122.03072105162873,-1.3556499789424894 122.02882880162696,-1.3543196039412502 122.02745217662569,-1.3532694789402724 122.02551330162387,-1.3518204789389228 122.02119505161986,-1.350932853938096 122.01850005161734,-1.3500546039372783 122.01657042661554,-1.3482802289356257 122.01299967661222,-1.3471577289345802 122.01124280161058,-1.3451759789327347 122.00942380160889,-1.3439633539316054 122.00838880160792,-1.342723978930451 122.0082461766078,-1.3420456039298192 122.0082501766078,-1.3414486039292632 122.00829880160785,-1.340761103928623 122.008474426608,-1.3401279789280334 122.00861555160814,-1.3395219789274688 122.00872142660823)')"),
            'status' => 'a'
        ]);

        SpatialData::create([
            'name'=> 'Sungai Single Poly',
            'restricted_area'=> '12947812382132',
            'type'=> 'HTI',
            'desc'=> 'data HTI terjadi',
            'created_by'=> 1,
            'polygon' => DB::raw("GeomFromText('Polygon((-1.616370229185304 122.06281392665862,-1.6142618541833404 122.06148192665738,-1.6124338541816379 122.06006242665605,-1.6087869791782414 122.05716767665335,-1.6067961041763874 122.05555230165186,-1.6035746041733872 122.05293442664941,-1.6018551041717857 122.05149330164807,-1.5992939791694005 122.04899492664575,-1.594361729164807 122.04421492664129,-1.5907962291614863 122.04126292663854,-1.5856832291567244 122.03705417663463,-1.5841088541552582 122.03610555163374,-1.5768066041484574 122.03181330162974,-1.5741193541459548 122.03034267662838,-1.5725089791444549 122.029931926628,-1.5711247291431658 122.0296248016277,-1.568103354140352 122.02947905162758,-1.5673707291396697 122.02953042662762,-1.565055104137513 122.02980117662787,-1.5627123541353312 122.03002542662807,-1.5540914791273024 122.02995630162802,-1.5473702291210427 122.0298303016279,-1.5434443541173863 122.03000967662807,-1.5361534791105962 122.03013280162818,-1.5333402291079763 122.03020517662824,-1.531929104106662 122.03043592662846,-1.5294597291043623 122.03081892662881,-1.527216479102273 122.03110117662908,-1.526637604101734 122.03125780162922,-1.525353354100538 122.0317635516297,-1.51719522909294 122.03476230163248,-1.5110088540871784 122.0371333016347,-1.5097516040860075 122.03743355163498,-1.5059978540825116 122.03835730163584,-1.501945854078738 122.0393934266368,-1.5009779790778366 122.03953592663693,-1.5000009790769266 122.03961980163702,-1.4972607290743745 122.04100980163831,-1.4963923540735657 122.04126930163855,-1.4952798540725298 122.04137667663865,-1.4945108540718135 122.04139067663866,-1.4939048540712492 122.04146517663874,-1.4929551040703646 122.04171717663897,-1.4922857290697413 122.04179242663903,-1.4913902290689072 122.04182767663907,-1.4904039790679888 122.0413326766386,-1.4887209790664213 122.04022355163758,-1.4867572290645925 122.03870005163616,-1.4841782290621905 122.03651592663412,-1.4827212290608336 122.03537505163305,-1.4809928540592239 122.03365530163146,-1.4794541040577909 122.03164080162958,-1.4788928540572681 122.0306954266287,-1.4783768540567876 122.02997867662803,-1.477879229056324 122.0295139266276,-1.4751102290537452 122.02733917662557,-1.4747209790533828 122.02677030162505,-1.4743949790530793 122.02610980162443,-1.4739149790526322 122.0247986766232,-1.4737607290524886 122.02379392662228,-1.4730723540518473 122.02170805162034,-1.4719492290508014 122.01832155161718,-1.471225104050127 122.01753705161644,-1.470799854049731 122.01714005161608,-1.4701302290491074 122.0166414266156,-1.4695238540485427 122.01621117661522,-1.4678591040469922 122.01523955161431,-1.4656786040449614 122.0144756766136,-1.4631093540425686 122.01376030161293,-1.4607299790403527 122.01322642661243,-1.4588753540386254 122.01281455161205,-1.456333354036258 122.01251042661177,-1.454098979034177 122.0126605516119,-1.4514308540316923 122.01329442661249,-1.4492963540297044 122.01424530161339,-1.4477771040282894 122.0152374266143,-1.446520479027119 122.017052926616,-1.4455354790262016 122.01911680161791,-1.4447764790254949 122.02129480161994,-1.4443526040251 122.02421430162266,-1.4439013540246797 122.02666555162494,-1.443867229024648 122.03149355162944,-1.4436336040244304 122.03506442663277,-1.4437976040245832 122.03802680163552,-1.443499979024306 122.03999742663737,-1.4428497290237003 122.0426096766398,-1.4423171040232043 122.04482180164186,-1.44108822902206 122.04828505164508,-1.4394801040205623 122.05341067664986,-1.439064354020175 122.05419117665059,-1.4379613540191478 122.05576542665204,-1.4367949790180614 122.05672230165294,-1.4345156040159386 122.05734230165352,-1.4339456040154077 122.05718530165338,-1.432425479013992 122.0562439266525,-1.4307693540124498 122.05454830165091,-1.4287154790105367 122.05364505165008,-1.426336104008321 122.05290280164938,-1.423848229006004 122.05245955164897,-1.4218219790041167 122.05240205164891,-1.4195426040019938 122.05279330164929,-1.416837978999475 122.05341542664986,-1.414766728997546 122.05405617665046,-1.4125598539954907 122.05472117665107,-1.410271103993359 122.05465305165102,-1.4082263539914548 122.05365805165009,-1.406515978989862 122.0520543016486,-1.40508572898853 122.04952205164624,-1.4041982289877033 122.04738642664425,-1.4032747289868432 122.04552630164251,-1.4019353539855959 122.04390930164101,-1.3999357289837335 122.04301680164018,-1.39564747897974 122.04176980163902,-1.3851891039699997 122.03872630163617,-1.376250603961675 122.03615480163378,-1.367854853953856 122.03347792663129,-1.363738353950022 122.03212680163003,-1.3615128539479495 122.0316584266296,-1.3592148539458093 122.03072105162873,-1.3556499789424894 122.02882880162696,-1.3543196039412502 122.02745217662569,-1.3532694789402724 122.02551330162387,-1.3518204789389228 122.02119505161986,-1.350932853938096 122.01850005161734,-1.3500546039372783 122.01657042661554,-1.3482802289356257 122.01299967661222,-1.3471577289345802 122.01124280161058,-1.3451759789327347 122.00942380160889,-1.3439633539316054 122.00838880160792,-1.342723978930451 122.0082461766078,-1.3420456039298192 122.0082501766078,-1.3414486039292632 122.00829880160785,-1.340761103928623 122.008474426608,-1.3401279789280334 122.00861555160814,-1.3395219789274688 122.00872142660823,-1.616370229185304 122.06281392665862))')"),
            'status' => 'a'
        ]);
    }
}
