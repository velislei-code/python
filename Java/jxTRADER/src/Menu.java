
import java.awt.Component;

import javax.swing.JMenuBar;
import javax.swing.JMenu;
import javax.swing.JMenuItem;
import javax.swing.JPopupMenu.Separator;
import javax.swing.JPanel;

/*
 * @ autor: Treuk, Velislei Adilson
 * Class construtora da bara de Menu - Não esta em uso (3/11/15)
 */
public class Menu {

	
    public void Construir(JPanel Painel){
    	
    	// Menu
    	JMenuBar BarraMenu = new JMenuBar(); 
		JMenu jMenuArq = new JMenu();
		JMenu jMenuFer = new JMenu();
		JMenu jMenuOpc = new JMenu();
		JMenu jMenuSis = new JMenu();		
		JMenu jMenuInf = new JMenu();
		
		
		
		//AddPainel(BarraMenu,1,1,objDef.LargDaTela,20);
		Painel.add(BarraMenu);
		BarraMenu.add(jMenuArq);
		BarraMenu.add(jMenuFer);
		BarraMenu.add(jMenuOpc);		
		BarraMenu.add(jMenuSis);
		BarraMenu.add(jMenuInf);
		
		jMenuArq.setText("Arquivo");		
		jMenuFer.setText("Ferramentas");
		jMenuOpc.setText("Opções");
		jMenuSis.setText("Sistema");
		jMenuInf.setText("Info");
		
		/*
		//Sub-Menus
		JMenu jMenuArqNovo = new JMenu();
		jMenuArq.add(jMenuArqNovo);
		
		jMenuArqNovo.setText("Novo");
		*/
		
		// Item de Menu
		
		JMenuItem jMenuArqNovo = new JMenuItem();
		JMenuItem jMenuArqAbrir = new JMenuItem();
		JMenuItem jMenuArqSalvar = new JMenuItem();
		JMenuItem jMenuArqSalvarAs = new JMenuItem();
		Separator Separador1 = new Separator();
		JMenuItem jMenuArqExportar = new JMenuItem();
		JMenuItem jMenuArqImportar = new JMenuItem();
		JMenuItem jMenuArqRestaurar = new JMenuItem();
		Separator Separador2 = new Separator();
		JMenuItem jMenuArqSair = new JMenuItem();
		
		jMenuArq.add(jMenuArqNovo);
		jMenuArq.add(jMenuArqAbrir);
		jMenuArq.add(jMenuArqSalvar);
		jMenuArq.add(jMenuArqSalvarAs);
		jMenuArq.add(Separador1);
		jMenuArq.add(jMenuArqExportar);
		jMenuArq.add(jMenuArqImportar);
		jMenuArq.add(jMenuArqRestaurar);
		jMenuArq.add(Separador2);
		jMenuArq.add(jMenuArqSair);
				
				
		jMenuArqNovo.setText("Novo");
		jMenuArqAbrir.setText("Abrir");
		jMenuArqSalvar.setText("Salvar");
		jMenuArqSalvarAs.setText("Salvar como");
		jMenuArqExportar.setText("Exportar");
		jMenuArqImportar.setText("ImportarXLS");
		jMenuArqRestaurar.setText("Restaurar");
		jMenuArqSair.setText("Sair");
		
		
		jMenuArqExportar.setIcon(new javax.swing.ImageIcon("imagens/Icon_btn/BtnTelnet16.png"));
		
		jMenuArqExportar.setSelected(true);
    }
    
    /*
    private static void AddMenu(JMenu Item , String sTitulo, int iAtalho)  
    {
         BarraMenu.add(Item);  // Adiciona componente ao painel                    
        // Item.setBounds( nColuna , nLinha , nLargura , nAltura ); // Fixa posição do componente
         Item.setText(sTitulo);
         
         switch (iAtalho){
         	case 1: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_A, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 2: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_B, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 3: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_C, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 4: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_D, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 5: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_E, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 6: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_F, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 7: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_G, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 8: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_H, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 9: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_I, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 10: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_J, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 11: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_K, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 12: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_L, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 13: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_M, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 14: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_N, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 15: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_O, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 16: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_P, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 17: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_Q, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 18: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_R, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 19: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_S, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 20: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_T, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 21: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_U, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 22: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_V, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 23: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_W, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 24: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_X, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 25: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_Y, java.awt.event.InputEvent.CTRL_MASK)); break;
         	case 26: Item.setAccelerator(javax.swing.KeyStroke.getKeyStroke(java.awt.event.KeyEvent.VK_Z, java.awt.event.InputEvent.CTRL_MASK)); break;
         	
         }
        
    }		
    */
    
    
}
