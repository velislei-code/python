/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//package br.velisleiat;

/**
 *
 * @author Soiuz
 */


import java.awt.EventQueue;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.ItemEvent;
import java.awt.event.ItemListener;
import java.text.DecimalFormat;
import java.text.NumberFormat;
import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.JTextField;
import javax.swing.JToggleButton;
import javax.swing.Timer;


class Clock {

//-----------------------------------------------------------	
private static final int N = 60;
private static final String sParar = "Stop";
private static final String sIniciar = "Start";
private final ClockListener clClock = new ClockListener();
private final Timer tTemporizador = new Timer(1000, clClock);
private final JTextField tfCampo = new JTextField(8);

//-----------------------------------------------------------
public Clock() {
    tTemporizador.setInitialDelay(0);

   // JPanel panel = new JPanel();
    //tfCampo.setHorizontalAlignment(JTextField.RIGHT);
    //tfCampo.setEditable(false);
    //panel.add(tfCampo);
    final JToggleButton btOnOff = new JToggleButton("sParar");
    btOnOff.addItemListener(new ItemListener() {

       //@Override
        public void itemStateChanged(ItemEvent e) {
            if (btOnOff.isSelected()) {
                tTemporizador.stop();
                btOnOff.setText(sIniciar);
            } else {
                tTemporizador.start();
                btOnOff.setText(sParar);
            }
        }
    });
    //panel.add(b);

    //this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
    //this.add(panel);
    //this.setTitle("Timer");
    //this.pack();
    //this.setLocationRelativeTo(null);
    //this.setVisible(true);
}

public void sIniciar() {
    tTemporizador.start();
}

private class ClockListener implements ActionListener {

    private int iHora;
    private int iMinuto;
    private int iSegundo;
    private String sHora;
    private String sMinuto;
    private String sSegundo;

    //@Override
    public void actionPerformed(ActionEvent e) {
        NumberFormat formatter = new DecimalFormat("00");
        if (iSegundo == N) {
            iSegundo = 00;
            iMinuto++;
        }

        if (iMinuto == N) {
            iMinuto = 00;
            iHora++;
        }
        sHora = formatter.format(iHora);
        sMinuto = formatter.format(iMinuto);
        sSegundo = formatter.format(iSegundo);
        tfCampo.setText(String.valueOf(sHora + ":" + sMinuto + ":" + sSegundo));
        iSegundo++;
        
       
    }
}

}
