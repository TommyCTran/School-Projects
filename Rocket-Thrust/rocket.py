# File:    Rocket.py
# Author:  Nghia Tran
# Date:    5/31/16
# Class: Numerical Computation
# E-mail:  t22@umbc.edu 
# Description:
# Consider a specific model rocket with a specific engine.
# Given all the data we can find, compute the maximum altitude
# the rocket can obtain. Yes, this is rocket science.

def printVar(t, s, v, a , m, outFile):
    print t, s, v, a, m
    outFile.write("%.1f, %.10f, %.10f, %.10f, %.10f" % (t, s, v, a, m))
    outFile.write('\n')
    return

def time(t):
    return t + 0.1

def thrust(thrustCurve):
    if len(thrustCurve) == 0:
        return 0.0
    else:
        return thrustCurve.pop(0)

def mass(m, Ft):
    return m - 0.0001644 * Ft

def gravity(m):
    return m * 9.80665

def force(Ft, FdBody, FdFins, Fg):
    return Ft - (FdBody + FdFins + Fg)

def acceleration(F, m):
    return F / m

def deltaVelocity(a):
    return a * 0.1

def velocity(v, dv):
    return v + dv

def deltaDistance(v):
    return v * 0.1

def distance(s, ds):
    return s + ds
    

def DragBody(v):
    return 0.45 * 1.293 * 0.000506 * v / 2
    
def DragFins(v):
    return 0.01 * 1.293 * 0.00496 * v / 2
    
def main():

    # Open output file
    outFile = open('ouput.txt', 'w')
    
    # Initial Conditions
    t = 0.0
    Ft = 0.0
    m = 0.0340 + 0.0242
    Fg = (0.0340 + 0.0242) * 9.80665
    F = 0
    a = 0
    dv = 0
    v = 0
    ds = 0
    s = 0
    FdBody = 0.45 * 1.293 * 0.000506 * 0 / 2
    FdFins = 0.01 * 1.293 * 0.00496 * 0 / 2
  
    
    # Thrust Curve
    thrustCurve = [7.5, 14.0, 5.0, 4.0, 4.0, 4.0, 4.0, 
                   4.0, 4.0, 4.0, 4.0, 4.0, 4.0, 4.0,
                   4.0, 4.0, 4.0, 4.0, 0.0, 0.0] 
    
    while v >= 0:
        
        # Print and write Functions
        # print("time: %.1f, height: %d, velocity: %d, acceleration: %d, mass: %.10f" % (t, s, v, a, m))
        printVar(t, s, v, a , m, outFile)
        
        # Physics based Functions
        t = time(t)
        Ft = thrust(thrustCurve)
        m = mass(m, Ft)
        Fg = gravity(m)
        F = force(Ft, FdBody, FdFins, Fg)
        a = acceleration(F, m)
        dv = deltaVelocity(a)
        v = velocity(v, dv)
        ds = deltaDistance(v)
        s = distance(s, ds)
        FdBody = DragBody(v)
        FdFins = DragFins(v)

        # Close output file
    outFile.close()
main()
