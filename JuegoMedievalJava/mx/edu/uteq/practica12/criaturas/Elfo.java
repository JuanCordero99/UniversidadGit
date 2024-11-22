package Practica12v3.mx.edu.uteq.practica12.criaturas;
import Practica12v3.mx.edu.uteq.practica12.util.comportamientos;

public class Elfo extends comportamientos {

    protected int pstVida = 100;

    public int getPstVida() {
        return pstVida;
    }
    
    public int setPstVida(int pstVida) {
        return this.pstVida = pstVida;
    }

    //COMPORTAMIENTOS COMUNES DE LAS ESPECIES

    @Override
    public String Presentacion() {
        return "YO SOY UN ELFO CON LOS PUNTOS DE FUERZA DE:\n"
        + "HABILIDAD ESPECIAL: " + DANO_ESPECIALIDAD_ELFO 
        + "\nPATADA: " + DANO_PATADA_ELFO
        + "\nPATADA: " + DANO_GOLPE_ELFO + "\n";
    }


    @Override
    public int danoEspecialidad() {
        return DANO_ESPECIALIDAD_ELFO;
    }


    @Override
    public int danoGolpe() {
        return DANO_GOLPE_ELFO;
    }

    @Override
    public int danoPatada() {
        return DANO_PATADA_ELFO;
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

    //!RECIBIENDO EL DAÑO DE CADA UNO DE LOS TIPOS DE GOLPES QUE HAY

    //!ENANO


    public int recibirPatadaEnano(Enano enano){
        return pstVida-enano.danoPatada();
    }
    public int recibirGolpeEnano(Enano enano){
        return pstVida-enano.danoGolpe();
    }
    public int recibirEspecialidadEnano(Enano enano){
        return setPstVida(pstVida-enano.danoEspecialidad());
    }

    //*TROLL

    public int recibirPatadaTroll(Troll troll){
        return pstVida-troll.danoPatada();
    }
    public int recibirGolpeTroll(Troll troll){
        return pstVida-troll.danoGolpe();
    }
    public int recibirEspecialidadTroll(Troll troll){
        return pstVida-troll.danoEspecialidad();
    }

}
