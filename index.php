 
<?php
$v1 = "";
$v2 = "";
$v3 = "";
$v4 = "";
$v5 = "";
$v6 = "";
$v7 = "";
$show = "style=\"display: none;\"";
$c1 = "<!--";
$c2 = "-->";
if(isset($_POST['1']))
{
$v1 = $_POST['1'];
$v2 = $_POST['2'];
$v3 = $_POST['3'];
$v4 = $_POST['4'];
$v5 = $_POST['5'];
$v6 = $_POST['6'];
$v7 = $_POST['7'];
$show = "";
$c1 = "";
$c2 = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo($c1); ?>    <link rel="stylesheet" href="https://pyscript.net/alpha/pyscript.css" />
    <script defer src="https://pyscript.net/alpha/pyscript.js"></script> <?php echo($c2); ?>  
    <link rel="stylesheet" href="style.css">
    <py-env <?php echo($show); ?>>
        - matplotlib
        - numpy
    </py-env>
    <title>Vector Plotter</title>
</head>
<body>
    <header style="display: flex;" class="header">
        <h1>Graphical vector equation plotter</h1>
        <p>Made with <a href="https://github.com/z-dodson/Graphical-Vector-Equation-Plotter">this python code</a> and pyscript, using the offline version on Github works a lot faster<br><a href="help.html"><button>Help</button></a></p>
    </header>
    <main>
        <div class="fromcont">
        <form action="./index.php" method="post" class="form">
            <h3>Enter equations here</h3>
                        <div><div><div style="background-color: red;"></div></div><input type="text" id="entry1" name="1" value="<?php echo($v1); ?>" style="color: red;"></div>
            <div><div><div style="background-color: green;"></div></div><input type="text" id="entry2" name="2" value="<?php echo($v2); ?>" style="color: green;"></div>
            <div><div><div style="background-color: blue;"></div></div><input type="text" id="entry3" name="3" value="<?php echo($v3); ?>" style="color: blue;"></div>
            <div><div><div style="background-color: brown;"></div></div><input type="text" id="entry4" name="4" value="<?php echo($v4); ?>" style="color: brown;"></div>
            <div><div><div style="background-color: orange;"></div></div><input type="text" id="entry5" name="5" value="<?php echo($v5); ?>" style="color: orange;"></div>
            <div><div><div style="background-color: pink;"></div></div><input type="text" id="entry6" name="6" value="<?php echo($v6); ?>" style="color: pink;"></div>
            <div><div><div style="background-color: yellow;"></div></div><input type="text" id="entry7" name="7" value="<?php echo($v7); ?>" style="color: yellow;"></div>
            <button><input id="sumbit" type="submit" value="Create graph"></button>
            
        </form>
        </div>
        <div id="pyout" <?php echo($show); ?>></div>
    </main>

<py-script output="pyout" <?php echo($show); ?>>
import numpy
import matplotlib.pyplot as pyplot
from matplotlib.widgets import TextBox
class Vector3D():
    """I am aware that python has classes that do this, but for me it amkes more sense to make it myself"""
    def __init__(self, a, b, c) -> None: self.a, self.b, self.c = float(a), float(b), float(c)
    def __str__(self) -> str: return f"[{int(self.a)},{int(self.b)},{int(self.c)}]"
    def __repr__(self) -> str: return f"[{int(self.a)},{int(self.b)},{int(self.c)}]"
    def __add__(self,other): return Vector3D(self.a+other.a, self.b+other.b, self.c+other.c)
    def __sub__(self,other): return Vector3D(self.a-other.a, self.b-other.b, self.c-other.c)
    def __mul__(self,other): return Vector3D(self.a*other.value, self.b*other.value, self.c*other.value)
    def dot(self,other): return self.a*other.a+self.b+other.b+self.c*other.c
    def cross(self, other): return Vector3D((self.b*other.c)-(self.c*other.b), -((self.a*other.c)-(self.c*other.a)), (self.a*other.b)-(self.b*other.a))
    def coords(self): return self.a, self.b, self.c
    def __abs__(self): return (self.a**2+self.b**2+self.c**2)**0.5
    def get(self): return self.a, self.b, self.c
    def __getitem__(self,i):
        if i==0: return self.a
        elif i==1: return self.b
        elif i==2: return self.c
    def gettype(self): return "Vector3D"
    def getVectorLinespace(self): return numpy.linspace(0,self.a, 2), numpy.linspace(0, self.b, 2), numpy.linspace(0, self.c, 2)
    def max(self):
        if self.a>self.b:
            if self.a>self.c: max = self.a
            else: max = self.c
        else:
            if self.b> self.c: max = self.b
            else: max = self.c
        return abs(max)
    def maxPos(self):
        if self.a>self.b:
            if self.a>self.c: max = 0
            else: max = 2
        else:
            if self.b> self.c: max = 1
            else: max = 2
        return max
class VectorFloat():
    """This allows floats to be mutilplies by vectors"""
    def __init__(self, value):
        self.value = float(value)
    def __add__(self,other): return VectorFloat(self.value+other.value)
    def __sub__(self,other): return VectorFloat(self.value-other.value)
    def gettype(self): return "VectorFloat"
    def __mul__(self, other): 
        if other.gettype()=="Vector3D": return Vector3D(self.value*other.a, self.value*other.b, self.value*other.c)
        else: return VectorFloat(self.value*other.value)
    def __str__(self) -> str: return f"{self.value}"
    def __repr__(self) -> str: return f"{self.value}"

class Line3D():
    def __init__(self,a1,a2,a3,b1,b2,b3):
        self.a1, self.a2, self.a3, self.b1, self.b2, self.b3 = a1,a2,a3,b1,b2,b3
    def __str__(self) -> str: 
        if self.a1>0: A=f"{self.a1}+{self.b2}"
        elif self.a1<0: A=f"{self.a1}{self.b2}"
        elif self.a1==0: A=f"{self.a1}"
        if self.b1!=1: A = f"({A})/{self.b1}"

        if self.a2>0: B=f"{self.a2}+{self.b2}"
        elif self.a2<0: B=f"{self.a2}{self.b2}"
        elif self.a2==0: B=f"{self.a2}"
        if self.b2!=1: B = f"({B})/{self.b2}"

        if self.a3>0: C =f"{self.a3}+{self.b3}"
        elif self.a3<0: C =f"{self.a3}{self.b3}"
        elif self.a3==0: C=f"{self.a3}"
        if self.b3!=1: C = f"({C})/{self.b3}"
        return f"{A}={B}={C}"
class Plane3D():
    """ax+by+cz=d"""
    def __init__(self,a,b,c,d): self.a, self.b, self.c, self.d = a, b, c, d
    def getXvalues(self, y, z): return (self.d-(y*self.b)-(z*self.c))/self.a
    def getYvalues(self, x, z): return (self.d-(x*self.a)-(z*self.c))/self.b
    def getZvalues(self, x, y): return (self.d-(x*self.a)-(y*self.b))/self.c
class Point3D():
    """I am aware that python has classes that do this, but for me it amkes more sense to make it myself"""
    def __init__(self, a, b, c) -> None: self.a, self.b, self.c = float(a), float(b), float(c)
    def __str__(self) -> str: return f"({self.a},{self.b},{self.c})"
    def __repr__(self) -> str: return f"({self.a},{self.b},{self.c})"
    def __getitem__(self,i):
        if i==0: return self.a
        elif i==1: return self.b
        elif i==2: return self.c
    def coords(self): return self.a, self.b, self.c
    def max(self):
        if self.a>self.b:
            if self.a>self.c: max = self.a
            else: max = self.c
        else:
            if self.b> self.c: max = self.b
            else: max = self.c
        return abs(max)
    def maxPos(self):
        if self.a>self.b:
            if self.a>self.c: max = 0
            else: max = 2
        else:
            if self.b> self.c: max = 1
            else: max = 2
        return max
    def gettype(self): return "Point3D"

colours = ['red','green','blue','brown','orange','pink','yellow']

def getLineLinespace(positionVector, directionVector, max):
    length = directionVector.max()+positionVector[directionVector.maxPos()]
    l = (max-positionVector[directionVector.maxPos()])/directionVector.max()
    neg_l = (-max-positionVector[directionVector.maxPos()])/directionVector.max()
    x1 = (positionVector[0]+l*directionVector[0])
    x2 = (positionVector[0]+neg_l*directionVector[0])
    y1 = (positionVector[1]+l*directionVector[1])
    y2 = (positionVector[1]+neg_l*directionVector[1])
    z1 = (positionVector[2]+l*directionVector[2])
    z2 = (positionVector[2]+neg_l*directionVector[2])
    return numpy.linspace(x1,x2, 2), numpy.linspace(y1,y2, 2), numpy.linspace(z1,z2, 2)

def getPlaneSpace(normalVector, value, axisLen):
    detail = 10
    line = Plane3D(*normalVector.get(), value.value)
    if normalVector[2]!=0:
        Xvalues = numpy.linspace(-axisLen,axisLen,detail)
        Yvalues = numpy.linspace(-axisLen,axisLen,detail)
        X,Y = numpy.meshgrid(Xvalues,Yvalues)
        Z = line.getZvalues(X,Y)
    elif normalVector[1]!=0:
        Xvalues = numpy.linspace(-axisLen,axisLen,detail)
        Zvalues = numpy.linspace(-axisLen,axisLen,detail)
        X,Z = numpy.meshgrid(Xvalues,Zvalues)
        Y = line.getYvalues(X,Z)
    elif normalVector[0]!=0:
        Yvalues = numpy.linspace(-axisLen,axisLen,detail)
        Zvalues = numpy.linspace(-axisLen,axisLen,detail)
        Y,Z = numpy.meshgrid(Yvalues,Zvalues)
        X = line.getYvalues(Y,Z)
    else: 
        alertInvalid()
    return X,Y,Z
def getLMPlaneSpace(positionVector, lamdaVector, muVector,a):
    normalVector = lamdaVector.cross(muVector)
    value = VectorFloat(positionVector.dot(normalVector))
    return getPlaneSpace(normalVector, value,a)

def alertInvalid(): print("INVALID")


class MatPlotLibController():
    def __init__(self):
        self.lines = []
    def plotAxes(self):
        global fig
        fig = pyplot.figure()# tight?
        self.axes = pyplot.axes(projection ='3d') # 3D graph
        self.axes.set_xlabel("X")
        self.axes.set_ylabel("Y")
        self.axes.set_zlabel("Z")
        self.axes.set_title('Vector Graph Plotter')
        #self.axislength = 10
        for thing in self.lines:# they're not all lines
            if thing[0]=="VECTOR" and thing[1].max()>self.axislength: self.axislength=int(thing[1].max())+1
            if thing[0]=="POINT" and thing[1].max()>self.axislength: self.axislength=int(thing[1].max())+1
            if thing[0]=="LINE" and thing[1].max()>self.axislength: self.axislength=int(thing[1].max())+1
                
        colour_n = 0

        #     if line[1].max()>self.axislength: self.axislength = line[1].max()

        for line in self.lines: colour_n = self.plot(line, colour_n)
            
        #self.axislength *= 1.2
        xAxis = [numpy.linspace(-self.axislength, self.axislength, 2),numpy.linspace(0, 0, 2),numpy.linspace(0, 0, 2)]#START, STOP, NUM OF POINTS
        yAxis = [numpy.linspace(0, 0, 2),numpy.linspace(self.axislength, -self.axislength, 2),numpy.linspace(0, 0, 2)]#START, STOP, NUM OF POINTS
        zAxis = [numpy.linspace(0, 0, 2),numpy.linspace(0, 0, 2),numpy.linspace(self.axislength, -self.axislength, 2)]#START, STOP, NUM OF POINTS
        self.axes.plot3D(*xAxis, 'black',linewidth=2)
        self.axes.plot3D(*yAxis, 'black',linewidth=2)
        self.axes.plot3D(*zAxis, 'black',linewidth=2)
        pyplot.tight_layout()
        pyplot.show()
        #fig # this should output the plot but it dosn't
    def reset(self): self.lines = []
    def addLine(self, line): self.lines.append(line)

    def plot(self,line, colour_n):
        if line[0]=="VECTOR":
            #self.axes.text(*line[1].coords(), f"{line[1]}", color=colours[colour_n])
            self.axes.plot3D(*line[1].getVectorLinespace(), colours[colour_n])
        elif line[0]=="LINE":
            #self.axes.text(*line[1].coords(), f"r={line[1]}+l{line[2]}", color=colours[colour_n])
            self.axes.plot3D(*getLineLinespace(line[1],line[2], self.axislength), colours[colour_n])
        elif line[0]=="PLANE":
            #self.axes.text(*line[1].coords(), f"r.{line[1]}={line[2]}", color=colours[colour_n])
            self.axes.plot_surface(*getPlaneSpace(line[1],line[2], self.axislength), color=colours[colour_n],alpha=0.5)
        elif line[0]=="LMPLANE":
            #self.axes.text(*line[1].coords(), f"r={line[1]}+l{line[2]}+m{line[3]}", color=colours[colour_n])
            self.axes.plot_surface(*getLMPlaneSpace(line[1],line[2],line[3], self.axislength), color=colours[colour_n],alpha=0.5)
        elif line[0]=="POINT":
            #self.axes.text(*line[1].coords(), f"{line[1]}", color=colours[colour_n])
            self.axes.scatter3D(*line[1].coords(), color=colours[colour_n])
        return colour_n+1
    def setMax(self, max): self.axislength = max

def doStuff(listofequations, max):
    controller.reset()
    controller.setMax(max)
    for equation in listofequations:
        #try:
        if 1:
            n = (deduceWhatItIs(equation))
            if n: controller.addLine(n)
            else: alertInvalid()
        #except: alertInvalid()
        
def deduceWhatItIs(equation):
    """I feel like this could be a big function"""
    
    if "="in equation:
        if equation[0:2]=="r=": # equation or lambda mu plane
            if "l"in equation:
                if "m" in equation:
                    return ("LMPLANE", *getLMPlane(equation))
                else: return ("LINE",*getLine(equation))# LINE
                    
        elif equation[0:3]=="r.[": # simple plane
            return ("PLANE",*getPlane(equation))
    elif "[" in equation and "]" in equation: return ("VECTOR", findVector(equation)) 
    elif "("==equation[0] and ")"==equation[-1]: return ("POINT", Point3D(*equation[1:-1].split(","))) 
    
        # this bit here should be a recursive function
    return None
    
def getPlane(equation):
    equation = equation.translate({ord(' '):None}) 
    vector, value = equation[2:].split("=")
    return Vector3D(*vector[1:-1].split(",")), VectorFloat(value)

def getLMPlane(equation):
    equation = equation.translate({ord(' '):None}) 
    equation = equation[2:]
    a,b,c = equation.split("+") # assume they in correct order
    return Vector3D(*a[1:-1].split(",")), Vector3D(*b[2:-1].split(",")), Vector3D(*c[2:-1].split(","))

def getPerpPlane(positionVector, directionVector):
    return directionVector, VectorFloat(positionVector.dot(directionVector))


def getLine(equation):
    """ preperation (cleaning string, etc)"""
    equation = str(equation)
    equation.replace(" ","")
    equation = equation[2:]
    a,b = equation.split("+")
    if "l" in a: a, b = b, a
    b = b.translate({ord('l'):None}) # replace didnt seem to be wroking properly so i used this ..?
    return Vector3D(*(a[1:-1].split(","))), Vector3D(*(b[1:-1].split(",")))

    
def findVector(equation):
    """
    recursiveFunctionForFindingVectorsWithoutEqualls
    Seems to work quite well despite recursion
    """
    #in the order of bidmas
    if"+"in equation:
        parts = equation.split("+")
        tot = Vector3D(0, 0, 0)
        for part in parts: tot = tot + findVector(part)
        return tot
    elif"*"in equation:
        parts = equation.split("*")
        tot = VectorFloat(1)
        for part in parts: tot = findVector(part) * tot
        return tot
    elif equation[0]=="["and equation[-1]=="]": # breakout cluase
        return Vector3D(*(equation[1:-1].split(",")))
    elif equation[0]=="("and equation[-1]==")": # breakout cluase
        return Point3D(*(equation[1:-1].split(",")))
    else:
        return VectorFloat(equation) # int
                
                    
            


    
fig = None
controller = MatPlotLibController()
t=[<?php echo("\"".$v1."\",\"".$v2."\",\"".$v3."\",\"".$v4."\",\"".$v5."\",\"".$v6."\",\"".$v7."\""); ?>]#### PHP
while""in t: t.remove("")
try: max = int(self.axisLenEntry.get().strip())
except: max = 15
doStuff(t, max)
controller.plotAxes()
pyplot
        
</py-script>
</body>
</html>