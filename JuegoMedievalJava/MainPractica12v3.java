package Practica12v3;

import Practica12v2.mx.edu.uteq.practica12.criaturas.*;
import Practica12v2.mx.edu.uteq.practica12.menu.*;
import java.util.Scanner;

public class MainPractica12v3 {
    public static void main(String[] args) {
        
        Scanner scan = new Scanner(System.in);

        Enano enano = new Enano();
        Elfo elfo = new Elfo();
        Troll troll = new Troll();

        SeleccionarElfo menuElfo = new SeleccionarElfo();
        SeleccionarEnano menuEnano = new SeleccionarEnano();
        SeleccionarTroll menuTroll = new SeleccionarTroll();

        System.out.println(enano.Presentacion());
        System.out.println(elfo.Presentacion());
        System.out.println(troll.Presentacion());
        
        //Ingresa la opcion para seleccionar un personaje
        String auxMenu; 
        System.out.print("Elige a tu personaje!" 
        + "\nEnano"
        + "\nElfo"
        + "\nTroll" + "\nIngresa el nombre de tu elección: ");
        auxMenu = scan.nextLine();
        auxMenu.toLowerCase();

        if(auxMenu.equals("elfo") ){
            menuElfo.decidirElfo();
        }else if(auxMenu.equals("enano") ){
            menuEnano.decidirEnano();
        }else if (auxMenu.equals("troll")){
            menuTroll.decidirTroll();
        }else{
            System.out.println("Ingresa una opcion valida");
        }
        
    }  

}
