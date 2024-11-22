package Practica12v3.mx.edu.uteq.practica12.menu;

import Practica12v3.mx.edu.uteq.practica12.criaturas.*;
import java.util.Scanner;

public class SeleccionarEnano {

    Scanner scan = new Scanner(System.in);
    String auxElecc, auxGolpe;
    Enano enano = new Enano();
    Elfo elfo = new Elfo();
    Troll troll = new Troll();

    public void decidirEnano(){
        
        while(true){             //!Enano
            System.out.println("!!Los trolls y los elfos te atacan!!" 
            +"\nPuedes elegir entre atacarlos o moverte de posición" 
            +"\nIngresa tu respuesta: |Atacar| o |moverte|"); 
            auxElecc = scan.nextLine();
            auxElecc.toLowerCase();

            if("moverte".equalsIgnoreCase(auxElecc)){
                int auxX, auxY;
                System.out.println("Dime a que coordenadas querras que se mueva el elfo:");
                System.out.print("X:"); 
                auxX = Integer.parseInt(scan.nextLine()); 
                System.out.print("Y:"); 
                auxY = Integer.parseInt(scan.nextLine());
                enano.setCoordenada(auxX, auxY);
                        
                }else if("atacar".equalsIgnoreCase(auxElecc)){

                    while(troll.getPstVida()>1 || elfo.getPstVida()>1){
                        String auxWhile;
                        System.out.println("\nIngresa a quien atacaras: " 
                        + "\nElfo"
                        + "\nTroll\n"); auxWhile= scan.nextLine();
                        auxWhile.toLowerCase();
                        switch (auxWhile) {
                            case "troll":
                                System.out.println("Elige el tipo de golpe " 
                                + "\nGolpe\nPatada\n!Especialidad!"
                                +"\n\n¿Con que tipo de golpe atacaras?" );auxGolpe = scan.nextLine();
                                auxGolpe.toLowerCase();

                                switch (auxGolpe) {
                                    case "golpe":
                                        troll.setPstVida(troll.recibirGolpeEnano(enano));
                                        System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                        + enano.getPstVida());     
                                        break;
                                        case "patada":
                                            troll.setPstVida(troll.recibirPatadaEnano(enano));
                                            System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                            + troll.getPstVida());     
                                            break;
                                        case "especialidad":
                                            troll.setPstVida(troll.recibirEspecialidadEnano(enano));
                                            System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                            + troll.getPstVida());     
                                            break;
                                        default:
                                            System.out.println("\n===|Ingresa una opcion valida|===");
                                            break;
                                    }
                                    break; //break caso enano
                            case "enano":
                                System.out.println("Elige el tipo de golpe " 
                                + "\nGolpe\nPatada\n!Especialidad!"
                                +"\n\n¿Con que tipo de golpe atacaras?" );auxGolpe = scan.nextLine();
                                auxGolpe.equalsIgnoreCase(auxGolpe);

                                switch (auxGolpe) {
                                    case "golpe":
                                        elfo.setPstVida(elfo.recibirGolpeEnano(enano));
                                        System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                        + elfo.getPstVida());     
                                        break;
                                    case "patada":
                                        elfo.setPstVida(elfo.recibirPatadaEnano(enano));
                                        System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                        + elfo.getPstVida());     
                                        break;
                                    case "especialidad":
                                        elfo.setPstVida(elfo.recibirEspecialidadEnano(enano));
                                        System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                        + elfo.getPstVida());     
                                        break;
                                    default:
                                        System.out.println("\n===|Ingresa una opcion valida|===");
                                        break;
                                }
                        }
                        if(elfo.getPstVida()<=0){
                            System.out.println("Has eliminado a un enemigo de los enanos");
                        }if(troll.getPstVida()<=0){
                            System.out.println("Has eliminado a un enemigo de los enanos");
                        }else if(troll.getPstVida()<=0 && elfo.getPstVida()<=0){
                            System.out.println("Has eliminado a ambos enemigos");
                            break;
                        }else{
                            continue;
                        }
                    }
                }
        }
    }
}
