import java.awt.Color;
import java.beans.PropertyChangeEvent;  
import java.beans.PropertyChangeListener;  

import javax.swing.JLabel;
import javax.swing.JScrollPane;  
import javax.swing.JTable;  
import javax.swing.JViewport;  
import javax.swing.event.ChangeEvent;  
import javax.swing.event.ChangeListener;  
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.TableColumn;  
import javax.swing.table.TableColumnModel;  
  
/* 
* A tabela já deve existir no painel de rolagem. 
* 
* A funcionalidade é feito através da criação de um segundo JTable (fixo) 
* Que irá partilhar o TableModel e SelectionModel da tabela principal. 
* Esta tabela será usada como cabeçalho da linha do painel de rolagem. 
* 
* O quadro fixo criado pode ser acessado usando o getFixedTable () 
* Método. serão devolvidos a partir deste método. Ele irá permitir que você: 
* 
* Você pode alterar o modelo da tabela principal e a mudança será 
* Refletido no modelo fixo. No entanto, você não pode mudar a estrutura 
* Do modelo.
*/  
public class RenderCongelarColuna implements ChangeListener, PropertyChangeListener {  
    private JTable TabPrincipal;  
    private JTable TabFixa;  
    private JScrollPane BarDeRolagem;  
  
    /* 
     *  Specify the number of columns to be TabFixa and the scroll pane 
     *  containing the table. 
     */  
    public RenderCongelarColuna(int FixarColunas, JScrollPane BarDeRolagem) {  
        this.BarDeRolagem = BarDeRolagem;  
        
        
        TabPrincipal = ((JTable) BarDeRolagem.getViewport().getView());  
        TabPrincipal.setAutoCreateColumnsFromModel(false);  
        TabPrincipal.addPropertyChangeListener(this);  
  
        //  Use the existing table to create a new table sharing  
        //  the DataModel and ListSelectionModel  
  
        int TotalDeColunas = TabPrincipal.getColumnCount();  
  
        TabFixa = new JTable();  
        TabFixa.setAutoCreateColumnsFromModel(false);  
        TabFixa.setModel(TabPrincipal.getModel());  
        TabFixa.setSelectionModel(TabPrincipal.getSelectionModel());  
        TabFixa.setFocusable(false);  
        TabFixa.setRowHeight(new Definicoes().iAlturaLinTab); 			// Altura da linha na Coluna Fixa
  
        //  Remove the TabFixa columns from the TabPrincipal table  
        //  and add them to the TabFixa table  
  
        for (int i = 0; i < FixarColunas; i++) {  
            TableColumnModel columnModel = TabPrincipal.getColumnModel();  
            TableColumn column = columnModel.getColumn(0);  
            columnModel.removeColumn(column);  
            TabFixa.getColumnModel().addColumn(column);  
            }  
        
  
        //  Add the TabFixa table to the scroll pane  
  
        TabFixa.setPreferredScrollableViewportSize(TabFixa.getPreferredSize());  
        BarDeRolagem.setRowHeaderView(TabFixa);  
        BarDeRolagem.setCorner(JScrollPane.UPPER_LEFT_CORNER, TabFixa.getTableHeader());  
  
        // Synchronize scrolling of the row header with the TabPrincipal table  
  
        BarDeRolagem.getRowHeader().addChangeListener(this); 
        
        
    }  
  
    /* 
     *  Return the table being used in the row header 
     */  
    public JTable getFixedTable() {  
        return TabFixa;  
    }  
//  
//  Implement the ChangeListener  
//  
  
    public void stateChanged(ChangeEvent e) {  
        //  Sync the scroll pane scrollbar with the row header  
  
        JViewport jvpVerPorta = (JViewport) e.getSource();  
        BarDeRolagem.getVerticalScrollBar().setValue(jvpVerPorta.getViewPosition().y);  
    }  
//  
//  Implement the PropertyChangeListener  
//  
  
    public void propertyChange(PropertyChangeEvent e) {  
        //  Keep the TabFixa table in sync with the TabPrincipal table  
        if ("selectionModel".equals(e.getPropertyName())) {  
            TabFixa.setSelectionModel(TabPrincipal.getSelectionModel());  
        }  
  
        if ("model".equals(e.getPropertyName())) {  
            TabFixa.setModel(TabPrincipal.getModel());  
        }  
        //NumerarLinhas(TabFixa);	// Numera as linhas
        // ReNumLinhas();
        NumerarModens();
        TabFixa.setBackground(Color.decode("#E8E8E8"));
   	 	TabFixa.setSelectionBackground(Color.CYAN); // Cor da linha selecionada
    }  
    
    public void NumerarLinhas(JTable TabFixa){
    // Numera linhas da Tabela de 0 a n
    	TabFixa = new JTable();
    	for(int iL=0; iL <= new Definicoes().pegueTotalLinTab(); iL++){ 
    		int iLx = iL + 1;		
    		TabFixa.setValueAt(iLx, iL, 0);		// Numera Linhas
    	}
	
	}
    
    public void NumerarModens(){
    	// Numera Linhas da Tabela(Col-Modem) de 4 em 4(0a3)
    	
    	// Centralizar conteudo			 
		DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
		centerRenderer.setHorizontalAlignment( JLabel.CENTER );
		TabFixa.getColumnModel().getColumn(0).setCellRenderer( centerRenderer ); // Centraliza conteudo da coluna
				
		// Numerar coluna N
    	int iLMd = 1;	// objDef.colN -> coluna(N) numeração das linhas da planilha
    	for(int iL=0; iL <= new Definicoes().pegueTotalLinTab(); iL++){ 

    		//if(iL%4 == 0){ iLMd = 0; }	 // Numera de 4em4, Se iL for Multiplo de quatro(modulo)...zera iLMd
    		TabFixa.setValueAt(iLMd, iL, 0); // Numera Linhas		
    		iLMd++;
    		
    	}
	
	}
    public void ReNumLinhas(){   
    	// Numera linhas da Tabela de 0 a n
    	//TabFixa = new JTable();
    	for(int iL=0; iL <= new Definicoes().pegueTotalLinTab(); iL++){ 
    		int iLx = iL + 1;		
    		TabFixa.setValueAt(iLx, iL, 0);		// Numera Linhas
    	}
	
	}
}  
