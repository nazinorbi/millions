/**
 * Created by nazinorbi on 2017. 01. 29..
 */



function Declarations(){
//Symbols as used in USGS PP 1395: Map Projections - A Working Manual
    DatumEqRad = [6378137.0,6378137.0,6378137.0,6378135.0,6378160.0,6378245.0,6378206.4,
        6378388.0,6378388.0,6378249.1,6378206.4,6377563.4,6377397.2,6377276.3];
    DatumFlat = [298.2572236, 298.2572236, 298.2572215,	298.2597208, 298.2497323, 298.2997381, 294.9786982,
        296.9993621, 296.9993621, 293.4660167, 294.9786982, 299.3247788, 299.1527052, 300.8021499];
    Item = 0;//Default
    k0 = 0.9996;//scale on central meridian
    a = DatumEqRad[Item];//equatorial radius, meters.
    f = 1/DatumFlat[Item];//polar flattening.
    b = a*(1-f);//polar axis.
    e = Math.sqrt(1 - b*b/a*a);//eccentricity
    drad = Math.PI/180;//Convert degrees to radians)
    latd = 0;//latitude in degrees
    phi = 0;//latitude (north +, south -), but uses phi in reference
    e0 = e/Math.sqrt(1 - e*e);//e prime in reference
    N = a/Math.sqrt(1-Math.pow(e*Math.sin(phi)),2);
    T = Math.pow(Math.tan(phi),2);
    C = Math.pow(e*Math.cos(phi),2);
    lng = 0;//Longitude (e = +, w = -) - can't use long - reserved word
    lng0 = 0;//longitude of central meridian
    lngd = 0;//longitude in degrees
    M = 0;//M requires calculation
    x = 0;//x coordinate
    y = 0;//y coordinate
    k = 1;//local scale
    utmz = 30;//utm zone
    zcm = 0;//zone central meridian
    DigraphLetrsE = "ABCDEFGHJKLMNPQRSTUVWXYZ";
    DigraphLetrsN = "ABCDEFGHJKLMNPQRSTUV";
    document.getElementById("EqRadBox").value = a;
    document.getElementById("PolRadBox").value = b;
    document.getElementById("FlatBox").value = f;
    document.getElementById("RecipBox").value = 1/f;
    OOZok = false;
}//Close declarations

function AllowOOZ(){
    OOZok = false;
    //if (document.getElementById("OOZBox").checked === true){OOZok=true;}
}

function DatumSelect(form)
{
    //alert (form.Datum.selectedIndex);
    Item = form.Datum.selectedIndex;
    ChosenType = form.Datum.options[Item].text;
    //alert (ChosenType);
    DatumEqRad = [6378137.0,6378137.0,6378137.0,6378135.0,6378160.0,6378245.0,6378206.4,
        6378388.0,6378388.0,6378249.1,6378206.4,6377563.4,6377397.2,6377276.3];
    DatumFlat = [298.2572236, 298.2572236, 298.2572215,	298.2597208, 298.2497323, 298.2997381, 294.9786982,
        296.9993621, 296.9993621, 293.4660167, 294.9786982, 299.3247788, 299.1527052, 300.8021499];
    k0 = 0.9996;//scale on central meridian
    a = DatumEqRad[Item];//equatorial radius, meters.
    f = 1/DatumFlat[Item];//polar flattening.
    b = a*(1-f);//polar axis.
    document.getElementById("EqRadBox").value = a;
    document.getElementById("PolRadBox").value = Math.floor(10*b)/10;
    document.getElementById("FlatBox").value = Math.floor(1e+7*f)/1e+7;
    document.getElementById("RecipBox").value = 1/f;
}
//Datum Info here: Name, a, b, f, 1/f
//WGS 84	6,378,137.0	6356752.314	0.003352811	298.2572236
//NAD 83	6,378,137.0	6356752.314	0.003352811	298.2572236
//GRS 80	6,378,137.0	6,356,752.3	0.003352811	298.2572215
//WGS 72	6,378,135.0	6,356,750.5	0.003352783	298.2597208
//Australian 1965	6,378,160.0	6,356,774.7	0.003352895	298.2497323
//Krasovsky 1940	6,378,245.0	6,356,863.0	0.003352333	298.2997381
//North American 1927	6,378,206.4	6,356,583.8	0.003390075	294.9786982
//International 1924	6,378,388.0	6,356,911.9	0.003367011	296.9993621
//Hayford 1909	6,378,388.0	6,356,911.9	0.003367011	296.9993621
//Clarke 1880	6,378,249.1	6,356,514.9	0.00340755	293.4660167
//Clarke 1866	6,378,206.4	6,356,583.8	0.003390075	294.9786982
//Airy 1830	6,377,563.4	6,356,256.9	0.003340853	299.3247788
//Bessel 1841	6,377,397.2	6,356,079.0	0.003342774	299.1527052
//Everest 1830	6,377,276.3	6,356,075.4	0.003324444	300.8021499


function EraseUTM(){
    document.getElementById("UTMzBox1").value = " ";
    document.getElementById("SHemBox").checked = false;
    document.getElementById("UTMeBox1").value = " ";
    document.getElementById("UTMnBox1").value = " ";
}

function EraseDDeg(){
    document.getElementById("DDLatBox0").value = " ";
    document.getElementById("DDLonBox0").value = " ";
}

function EraseDMS(){
    document.getElementById("DLatBox0").value = " ";
    document.getElementById("MLatBox0").value = " ";
    document.getElementById("SLatBox0").value = " ";
    document.getElementById("DLonBox0").value = " ";
    document.getElementById("MLonBox0").value = " ";
    document.getElementById("SLonBox0").value = " ";
}

function EraseNATO(){
    document.getElementById("UTMLonZoneBox2").value = " ";
    document.getElementById("UTMLatZoneBox2").value = " ";
    document.getElementById("UTMDgBox2").value = " ";
    document.getElementById("UTMeBox2").value = " ";
    document.getElementById("UTMnBox2").value = " ";
}

function EraseDeg(){
    EraseDDeg();
    EraseDMS();
}

function EraseAll(){
    EraseDDeg();
    EraseDMS();
    EraseUTM();
    EraseNATO();
}

//List of Boxes
//UTMzBox1
//SHemBox
//UTMeBox1
//UTMnBox1
//DDLatBox0
//DDLonBox0
//DLatBox0
//MLatBox0
//SLatBox0
//DLonBox0
//MLonBox0
//SLonBox0
//UTMLonZoneBox2
//UTMLatZoneBox2
//UTMDgBox2
//UTMeBox2
//UTMnBox2

function MakeDigraph(){
    //Inputs y utmz
    //alert(utmz);
    Letr = Math.floor((utmz-1)*8 + (x)/100000);
    Letr = Letr - 24*Math.floor(Letr/24)-1;
    Digraph = DigraphLetrsE.charAt(Letr);
    //alert("x=   "+x);
    //alert(DigraphLetrsE.charAt(Letr));
    //First (Easting) Character Found
    Letr = Math.floor(y/100000);
    //Odd zones start with A at equator, even zones with F
    if (utmz/2 == Math.floor(utmz/2)){Letr = Letr+5;}
    Letr = Letr - 20*Math.floor(Letr/20);
    Digraph = Digraph + DigraphLetrsN.charAt(Letr);
}//End MakeDigraph


function DigraphtoUTM(){
    //Input Digraph, utmz
    //Outputs Nbase Ebase
}//End Digraph to UTM

function DDtoDMS(){
    //Input= xd(long) and yd(lat)
    //Output = xdd xm xs (long) and ydd ym ys (lat)
    ydd = Math.floor(Math.abs(yd));
    ym = Math.floor(60*(Math.abs(yd) - ydd));
    ys = 3600*(Math.abs(yd)-ydd - ym/60);
    if (yd<0){ydd=-ydd;}
    xdd = Math.floor(Math.abs(xd));
    xm = Math.floor(60*(Math.abs(xd) - xdd));
    xs = 3600*(Math.abs(xd)-xdd - xm/60);
    if (xd<0){xdd=-xdd;}
}//End DDtoDMS

function DMStoDD(){
    //Input = xdd xm xs (long) and ydd ym ys (lat)
    //Output= xd(long) and yd(lat)
    xd = Math.abs(xdd) + xm/60 + xs/3600;
    yd = Math.abs(ydd) + ym/60 + ys/3600;
    if (ydd<0){yd=-yd;}
    if (xdd<0){xd=-xd;}
}//End DMStoDD


function GeogToUTM(){
    //Convert Latitude and Longitude to UTM
    Declarations();
    k0 = 0.9996;//scale on central meridian
    b = a*(1-f);//polar axis.
    //alert(a+"   "+b);
    //alert(1-(b/a)*(b/a));
    e = Math.sqrt(1 - (b/a)*(b/a));//eccentricity
    //alert(e);
    //Input Geographic Coordinates
    //Decimal Degree Option
    latd0 = parseFloat(document.getElementById("DDLatBox0").value);
    lngd0 = parseFloat(document.getElementById("DDLonBox0").value);
    latd1 = Math.abs(parseFloat(document.getElementById("DLatBox0").value));
    latd1 = latd1 + parseFloat(document.getElementById("MLatBox0").value)/60;
    latd1 = latd1 + parseFloat(document.getElementById("SLatBox0").value)/3600;
    if (parseFloat(document.getElementById("DLatBox0").value)<0){latd1=-latd1;}
    lngd1 = Math.abs(parseFloat(document.getElementById("DLonBox0").value));
    lngd1 = lngd1 + parseFloat(document.getElementById("MLonBox0").value)/60;
    lngd1 = lngd1 + parseFloat(document.getElementById("SLonBox0").value)/3600;
    if (parseFloat(document.getElementById("DLonBox0").value)<0){lngd1=-lngd1;}

    lngd=lngd0;
    latd=latd0;
    if(isNaN(latd)){
        latd = latd1;
        document.getElementById("DDLatBox0").value = Math.floor(1000000*latd)/1000000;
        lngd=lngd1;
        document.getElementById("DDLonBox0").value = Math.floor(1000000*lngd)/1000000;
    }

    if(isNaN(lngd)){lngd = latd1;}
    if(isNaN(latd)|| isNaN(lngd)){
        alert("Non-Numeric Input Value");
    }
    if(latd <-90 || latd> 90){
        alert("Latitude must be between -90 and 90");
    }
    if(lngd <-180 || lngd > 180){
        alert("Latitude must be between -180 and 180");
    }

    xd = lngd;
    yd = latd;
    DDtoDMS();
    //Read Input from DMS Boxes
    document.getElementById("DLatBox0").value = Math.floor(ydd);
    document.getElementById("MLatBox0").value = ym;
    document.getElementById("SLatBox0").value = Math.floor(1000*ys)/1000;
    document.getElementById("DLonBox0").value = Math.floor(xdd);
    document.getElementById("MLonBox0").value = xm;
    document.getElementById("SLonBox0").value = Math.floor(1000*xs)/1000;


    phi = latd*drad;//Convert latitude to radians
    lng = lngd*drad;//Convert longitude to radians
    utmz = 1 + Math.floor((lngd+180)/6);//calculate utm zone
    latz = 0;//Latitude zone: A-B S of -80, C-W -80 to +72, X 72-84, Y,Z N of 84
    if (latd > -80 && latd < 72){latz = Math.floor((latd + 80)/8)+2;}
    if (latd > 72 && latd < 84){latz = 21;}
    if (latd > 84){latz = 23;}

    zcm = 3 + 6*(utmz-1) - 180;//Central meridian of zone
    //alert(utmz + "   " + zcm);
    //Calculate Intermediate Terms
    e0 = e/Math.sqrt(1 - e*e);//Called e prime in reference
    esq = (1 - (b/a)*(b/a));//e squared for use in expansions
    e0sq = e*e/(1-e*e);// e0 squared - always even powers
    //alert(esq+"   "+e0sq)
    N = a/Math.sqrt(1-Math.pow(e*Math.sin(phi),2));
    //alert(1-Math.pow(e*Math.sin(phi),2));
    //alert("N=  "+N);
    T = Math.pow(Math.tan(phi),2);
    //alert("T=  "+T);
    C = e0sq*Math.pow(Math.cos(phi),2);
    //alert("C=  "+C);
    A = (lngd-zcm)*drad*Math.cos(phi);
    //alert("A=  "+A);
    //Calculate M
    M = phi*(1 - esq*(1/4 + esq*(3/64 + 5*esq/256)));
    M = M - Math.sin(2*phi)*(esq*(3/8 + esq*(3/32 + 45*esq/1024)));
    M = M + Math.sin(4*phi)*(esq*esq*(15/256 + esq*45/1024));
    M = M - Math.sin(6*phi)*(esq*esq*esq*(35/3072));
    M = M*a;//Arc length along standard meridian
    //alert(a*(1 - esq*(1/4 + esq*(3/64 + 5*esq/256))));
    //alert(a*(esq*(3/8 + esq*(3/32 + 45*esq/1024))));
    //alert(a*(esq*esq*(15/256 + esq*45/1024)));
    //alert(a*esq*esq*esq*(35/3072));
    //alert(M);
    M0 = 0;//M0 is M for some origin latitude other than zero. Not needed for standard UTM
    //alert("M    ="+M);
    //Calculate UTM Values
    x = k0*N*A*(1 + A*A*((1-T+C)/6 + A*A*(5 - 18*T + T*T + 72*C -58*e0sq)/120));//Easting relative to CM
    x=x+500000;//Easting standard
    y = k0*(M - M0 + N*Math.tan(phi)*(A*A*(1/2 + A*A*((5 - T + 9*C + 4*C*C)/24 + A*A*(61 - 58*T + T*T + 600*C - 330*e0sq)/720))));//Northing from equator
    yg = y + 10000000;//yg = y global, from S. Pole
    if (y < 0){y = 10000000+y;}
    //Output into UTM Boxes
    document.getElementById("UTMzBox1").value = utmz;
    document.getElementById("UTMeBox1").value = Math.round(10*(x))/10;
    document.getElementById("UTMnBox1").value = Math.round(10*y)/10;
    if (phi<0){document.getElementById("SHemBox").checked=true;}
    //document.getElementById("UTMzBox1").value = utmz;
    //document.getElementById("UTMeBox1").value = Math.round(10*(500000+x))/10;
    document.getElementById("UTMLonZoneBox2").value = utmz;
    document.getElementById("UTMLatZoneBox2").value = DigraphLetrsE[latz];
    document.getElementById("UTMeBox2").value = Math.round(10*(x-100000*Math.floor(x/100000)))/10;
    document.getElementById("UTMnBox2").value = Math.round(10*(y-100000*Math.floor(y/100000)))/10;
//Generate Digraph
    MakeDigraph();
    document.getElementById("UTMDgBox2").value = Digraph;

}//close Geog to UTM
///////////////////////////////////////////////////////////////////////

function UTMtoGeog(){
    //Convert UTM Coordinates to Geographic
    Declarations();
    k0 = 0.9996;//scale on central meridian
    b = a*(1-f);//polar axis.
    e = Math.sqrt(1 - (b/a)*(b/a));//eccentricity
    e0 = e/Math.sqrt(1 - e*e);//Called e prime in reference
    esq = (1 - (b/a)*(b/a));//e squared for use in expansions
    e0sq = e*e/(1-e*e);// e0 squared - always even powers
    x = parseFloat(document.getElementById("UTMeBox1").value);
    if (x<160000 || x>840000){alert("Outside permissible range of easting values \n Results may be unreliable \n Use with caution");}
    y = parseFloat(document.getElementById("UTMnBox1").value);
    //alert(y)
    if (y<0){alert("Negative values not allowed \n Results may be unreliable \n Use with caution");}
    if (y>10000000){alert("Northing may not exceed 10,000,000 \n Results may be unreliable \n Use with caution");}
    utmz = parseFloat(document.getElementById("UTMzBox1").value);
    zcm = 3 + 6*(utmz-1) - 180;//Central meridian of zone
    e1 = (1 - Math.sqrt(1 - e*e))/(1 + Math.sqrt(1 - e*e));//Called e1 in USGS PP 1395 also
    M0 = 0;//In case origin other than zero lat - not needed for standard UTM
    M = M0 + y/k0;//Arc length along standard meridian.
    if (document.getElementById("SHemBox").checked === true){M=M0+(y-10000000)/k;}
    mu = M/(a*(1 - esq*(1/4 + esq*(3/64 + 5*esq/256))));
    phi1 = mu + e1*(3/2 - 27*e1*e1/32)*Math.sin(2*mu) + e1*e1*(21/16 -55*e1*e1/32)*Math.sin(4*mu);//Footprint Latitude
    phi1 = phi1 + e1*e1*e1*(Math.sin(6*mu)*151/96 + e1*Math.sin(8*mu)*1097/512);
    C1 = e0sq*Math.pow(Math.cos(phi1),2);
    T1 = Math.pow(Math.tan(phi1),2);
    N1 = a/Math.sqrt(1-Math.pow(e*Math.sin(phi1),2));
    R1 = N1*(1-e*e)/(1-Math.pow(e*Math.sin(phi1),2));
    D = (x-500000)/(N1*k0);
    phi = (D*D)*(1/2 - D*D*(5 + 3*T1 + 10*C1 - 4*C1*C1 - 9*e0sq)/24);
    phi = phi + Math.pow(D,6)*(61 + 90*T1 + 298*C1 + 45*T1*T1 -252*e0sq - 3*C1*C1)/720;
    phi = phi1 - (N1*Math.tan(phi1)/R1)*phi;

//Output Latitude
    document.getElementById("DDLatBox0").value = Math.floor(1000000*phi/drad)/1000000;

//Longitude
    lng = D*(1 + D*D*((-1 -2*T1 -C1)/6 + D*D*(5 - 2*C1 + 28*T1 - 3*C1*C1 +8*e0sq + 24*T1*T1)/120))/Math.cos(phi1);
    lngd = zcm+lng/drad;

//Output Longitude
    document.getElementById("DDLonBox0").value = Math.floor(1000000*lngd)/1000000;
//Parse DMS
    xd = lngd;
    yd = phi/drad;
    DDtoDMS();
    document.getElementById("DLatBox0").value = Math.floor(ydd);
    document.getElementById("MLatBox0").value = ym;
    document.getElementById("SLatBox0").value = Math.floor(1000*ys)/1000;
    document.getElementById("DLonBox0").value = Math.floor(xdd);
    document.getElementById("MLonBox0").value = xm;
    document.getElementById("SLonBox0").value = Math.floor(1000*xs)/1000;

    document.getElementById("UTMLonZoneBox2").value = utmz;
    document.getElementById("UTMLatZoneBox2").value = DigraphLetrsE[latz];
    document.getElementById("UTMeBox2").value = Math.round(10*(x-100000*Math.floor(x/100000)))/10;
    document.getElementById("UTMnBox2").value = Math.round(10*(y-100000*Math.floor(y/100000)))/10;
    MakeDigraph();
    document.getElementById("UTMDgBox2").value = Digraph;

}//End UTM to Geog

function NATOtoGeog(){
    AllDGLetrs = "ABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUVABCDEFGHJKLMNPQRSTUV";
    Latz = document.getElementById("UTMLatZoneBox2").value;
    Latz = Latz.toUpperCase();
    Latz = Latz.charAt(0);
    document.getElementById("UTMLatZoneBox2").value = Latz;
    if (Latz=="I" || Latz=="O"){alert("I and O are not permissible zone letters");
        return;}
    Digraph = document.getElementById("UTMDgBox2").value;
    Digraph = Digraph.toUpperCase();
    if (Digraph.length < 2){alert("Incomplete Digraph");
        return;}
    document.getElementById("UTMDgBox2").value = Digraph;
    utmz = parseFloat(document.getElementById("UTMLonZoneBox2").value);
    if(isNaN(utmz)){alert("Longitude zone must have a numeric value");
        return;}
    if(utmz <1 || utmz>60){alert("Longitude zone number must be between 1 and 60");
        return;}
    utmz = parseFloat(document.getElementById("UTMLonZoneBox2").value);
    utme = parseFloat(document.getElementById("UTMeBox2").value);
    utmn = parseFloat(document.getElementById("UTMnBox2").value);
    if (isNaN(utme)||isNaN(utmn)){alert("Non-numeric coordinate values");
        return;}
    if (utme < 0 || utmn<0){alert("UTM coordinates must always be positive");
        return;}
    if (utme >=100000 || utmn>=100000){alert("NATO UTM coordinates must always be less than 100000");
        return;}
    ELetr = Digraph.charAt(0);
    if (ELetr=="I" || ELetr=="O"){alert("I and O are not permissible digraph letters");
        return;}
    NLetr = Digraph.charAt(1);
    EIndx = DigraphLetrsE.indexOf(ELetr);
    NIndx = DigraphLetrsN.indexOf(NLetr);
    if (NLetr=="I" || ELetr=="O"){alert("I and O are not permissible digraph letters");
        return;}
    if (NLetr=="W" || NLetr=="X" || NLetr=="Y" || NLetr=="Z"){alert("W,X,Y or Z are not permissible second digraph letters");
        return;}
    if (utmz/2 == Math.floor(utmz/2)){NIndx = NIndx-5;}//correction for even zones
    //Check Compatibility of Zones and Digraph
    //Check Long Zone
    //Zone 1: 1-8; Zone 2: 9-16; Zone 3: 17-24
    if ((Math.floor((EIndx)/8)) != ((utmz-1)-3*Math.floor((utmz-1)/3))){
        alert("WARNING! \n Longitude zone and Digraph are inconsistent.\n Results may be unreliable.\n Use with caution");
    }
    EBase = 100000*(1+DigraphLetrsE.indexOf(ELetr)-8*Math.floor(DigraphLetrsE.indexOf(ELetr)/8))

    //Now Latitude Zones
    //N Lat: 100km band = 8.88(NIndx-12) to 8.88(NIndx-11)
    LatBand = DigraphLetrsE.indexOf(Latz);//Digraph letters E use same set as Lat zone designations
    LatBandLow = 8*LatBand-96;
    LatBandHigh = 8*LatBand-88;
    //Lat Band C starts at -80 but is index 2 in the letters list, hence -80-16 = -96, etc.
    if (LatBand<2){LatBandLow = -90;
        LatBandHigh=-80;}
    if (LatBand==21){LatBandLow=72;
        LatBandHigh=84;}
    if (LatBand>21){LatBandLow=84;
        LatBandHigh=90;}
    //alert(LatBandLow + "   " + LatBandHigh);
    //One degree = 10000km/90, lat band = 8 degrees = 80000/90 = 889km
    LowLetr=Math.floor(100+1.11*LatBandLow);
    HighLetr=Math.round(100+1.11*LatBandHigh);
    //Adjust for even zones
    //alert(LowLetr + "  " + HighLetr);
    LatBandLetrs = AllDGLetrs.slice(LowLetr,HighLetr);
    if (utmz/2 == Math.floor(utmz/2)){LatBandLetrs = AllDGLetrs.slice(LowLetr+5,HighLetr+5);}//Deal with even zones
    //alert(NLetr + "  " + LatBandLetrs);
    if(LatBandLetrs.indexOf(NLetr)<0){alert("WARNING! \n Latitude zone and Digraph are inconsistent.\n Results may be unreliable.\n Use with caution");}
    NBase = 100000*(LowLetr + LatBandLetrs.indexOf(NLetr));
    x=EBase+utme;
    y=NBase+utmn;
    //alert("NATO");
    if (y > 10000000){y=y-10000000;}
    if (NBase>=1e+7){y=NBase+utmn-1e+7;}
    if (NBase<1e+7){document.getElementById("SHemBox").checked = true;}//Southern Hemisphere
    document.getElementById("UTMeBox2").value = x;
    document.getElementById("UTMnBox2").value = y;
    document.getElementById("UTMeBox1").value = x;
    document.getElementById("UTMnBox1").value = y;
    document.getElementById("UTMzBox1").value = document.getElementById("UTMLonZoneBox2").value;

    UTMtoGeog();
    //alert(x +"  "+y);
}


