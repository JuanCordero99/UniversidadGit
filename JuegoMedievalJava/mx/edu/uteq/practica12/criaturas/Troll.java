package Practica12v3.mx.edu.uteq.practica12.criaturas;
import Practica12v3.mx.edu.uteq.practica12.util.comportamientos;

public class Troll extends comportamientos{

    protected int pstVida = 100;
    
    public int getPstVida() {
        return pstVida;
    }

    public void setPstVida(int ptsVida) {
        this.pstVida = ptsVida;
    }
    @Override
    public int getX() {
        return x;
    }

    @Override
    public int getY() {
        return y;
    }

    @Override
    public void setCoordenada(int x, int y) {
        this.x = x;
        this.y = y;
    }

    @Override
    public String Presentacion() {        
        return "YO SOY UN TROLL CON CON LOS PUNTOS DE FUERZA DE: "
        + "\nHABILIDAD ESPECIAL: " + DANO_ESPECIALIDAD_TROLL 
        + "\nPATADA: " + DANO_PATADA_TROLL
        + "\nPATADA: " + DANO_GOLPE_TROLL + "\n";
    }

    @Override
    public int danoEspecialidad() {
        return DANO_ESPECIALIDAD_TROLL;
    }

    @Override
    public int danoGolpe() {
        return DANO_GOLPE_TROLL;
    }

    @Override
    public int danoPatada() {
        return DANO_PATADA_TROLL;
    }

    //!RECIBIENDO EL DAÑO DE CADA UNO DE LOS TIPOS DE GOLPES QUE HAY

    //!ENANO

    public int recibirPatadaEnano(Enano enano){
        return pstVida-enano.danoPatada();
    }
    public int recibirGolpeEnano(Enano enano){
        return pstVida-enano.danoGolpe();
    }
    public int recibirEspecialidadEnano(Enano enano){
        return pstVida-enano.danoEspecialidad();
    }

    //?ELFO

    public int recibirPatadaElfo(Elfo elfo){
        return pstVida-elfo.danoPatada();
    }
    public int recibirGolpeELfo(Elfo elfo){
        return pstVida-elfo.danoGolpe();
    }
    public int recibirEspecialidadElfo(Elfo elfo){
        return pstVida-elfo.danoEspecialidad();
    }
    
}
