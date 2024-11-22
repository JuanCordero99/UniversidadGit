package Practica12v3.mx.edu.uteq.practica12.menu;

import Practica12v3.mx.edu.uteq.practica12.criaturas.*;
import java.util.Scanner;

public class SeleccionarTroll {

    Scanner scan = new Scanner(System.in);
    String auxElecc, auxGolpe;

    Enano enano = new Enano();
    Elfo elfo = new Elfo();
    Troll troll = new Troll();
    
    public void decidirTroll(){
        
        while(true){             //!roll
            System.out.println("!!Los elfos y los enanos te atacan!!" 
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
                elfo.setCoordenada(auxX, auxY);
                        
            }else if("atacar".equalsIgnoreCase(auxElecc)){

                while(elfo.getPstVida()>1 && enano.getPstVida()>1){
                    String auxWhile;
                    System.out.println("\nIngresa a quien atacaras: " 
                    + "\nEnano"
                    + "\nElfo\n"); auxWhile= scan.nextLine();
                    switch (auxWhile) {
                        case "elfo":
                            System.out.println("Elige el tipo de golpe " 
                            + "\nGolpe\nPatada\n!Especialidad!"
                            +"\n\n¿Con que tipo de golpe atacaras?" );
                            auxGolpe = scan.nextLine();
                            auxGolpe.toLowerCase();

                            switch (auxGolpe) {
                                case "golpe":
                                    elfo.setPstVida(elfo.recibirGolpeTroll(troll));
                                    System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                    + elfo.getPstVida());     
                                    break;
                                case "patada":
                                    elfo.setPstVida(elfo.recibirPatadaTroll(troll));
                                    System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                    + elfo.getPstVida());     
                                    break;
                                case "especialidad":
                                    elfo.setPstVida(elfo.recibirEspecialidadTroll(troll));
                                    System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                    + elfo.getPstVida());     
                                    break;
                                default:
                                    System.out.println("\n===|Ingresa una opcion valida|===");
                                    break;
                            }
                        case "enano":
                            System.out.println("Elige el tipo de golpe " 
                            + "\nGolpe\nPatada\n!Especialidad!"
                            +"\n\n¿Con que tipo de golpe atacaras?" );auxGolpe = scan.nextLine();
                            auxGolpe.equalsIgnoreCase(auxGolpe);

                            switch (auxGolpe) {
                                case "golpe":
                                    enano.setPstVida(enano.recibirGolpeTroll(troll));
                                    System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                    + enano.getPstVida());     
                                    break;
                                case "patada":
                                            enano.setPstVida(enano.recibirPatadaTroll(troll));
                                            System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                            + elfo.getPstVida());     
                                            break;
                                case "especialidad":
                                        enano.setPstVida(enano.recibirEspecialidadTroll(troll));
                                        System.out.println("EL ataque lo ha dejado con los puntos de vida de: "
                                        + enano.getPstVida());     
                                        break;
                                default:
                                        System.out.println("\n===|Ingresa una opcion valida|===");
                                        break;
                            }
                        default:
                            System.out.println("Ingresa una opcion valida");
                            break;
                    }
                    if(enano.getPstVida()<=0){
                        System.out.println("Has eliminado a un enemigo de los enanos");
                    }if(elfo.getPstVida()<=0){
                        System.out.println("Has eliminado a un enemigo de los enanos");
                    }else if(elfo.getPstVida()<=0 && enano.getPstVida()<=0){
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

