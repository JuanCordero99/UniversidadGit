package Practica12v3.mx.edu.uteq.practica12.util;

public abstract class comportamientos implements puntosFuerza{
    
    protected int x,y;

    public abstract void setCoordenada(int x, int y);
    public abstract int getX();
    public abstract int getY();

    public abstract int danoGolpe();
    public abstract int danoPatada();
    public abstract int danoEspecialidad();
    public abstract String Presentacion();

}
