package Practica12v3.mx.edu.uteq.practica12.criaturas;
import Practica12v3.mx.edu.uteq.practica12.util.comportamientos;

public class Enano extends comportamientos {

    protected int pstVida = 100;

    public int getPstVida() {
        return pstVida;
    }

    public void setPstVida(int pstVida) {
        this.pstVida = pstVida;
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
        return "YO SOY UN ENANO CON CON LOS PUNTOS DE FUERZA DE: "
        + "\nHABILIDAD ESPECIAL: " + DANO_ESPECIALIDAD_ENANO 
        + "\nPATADA: " + DANO_PATADA_ENANO
        + "\nPATADA: " + DANO_GOLPE_ENANO +"\n";
    }

    @Override
    public int danoEspecialidad() {
        return DANO_ESPECIALIDAD_ENANO;
    }

    @Override
    public int danoGolpe() {
        return DANO_GOLPE_ENANO;
    }

    @Override
    public int danoPatada() {
        return DANO_PATADA_ENANO;
    }

    //!RECIBIENDO EL DAÑO DE CADA UNO DE LOS TIPOS DE GOLPES QUE HAY

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

    //?ELFO

    public int recibirPatadaElfo(Elfo elfo){
        return pstVida-elfo.danoPatada();
    }
    public int recibirGolpeElfo(Elfo elfo){
        return pstVida-elfo.danoGolpe();
    }
    public int recibirEspecialidadElfo(Elfo elfo){
        return pstVida-elfo.danoEspecialidad();
    }
    //TODO manera de implementar switches
    /*public String algo(int valor){
        String resultado="";
        switch (valor) {
            case 1:
                
            resultado=
                break;
        
            default:
                break;
        }
        return resultado;
    }*/
    
}
