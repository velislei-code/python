import java.awt.Color;
import java.awt.Component;

import javax.swing.JTable;
import javax.swing.table.DefaultTableCellRenderer;

class RenderListras extends DefaultTableCellRenderer 
{
//private static final long serialVersionUID = 6703872492730589499L;

    public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column)
    {
    	
        Component cellComponent = super.getTableCellRendererComponent(table, value, isSelected, hasFocus, row, column);
        /*
         * Linha Par: Pinta
         * Linha Impar: não-pinta
         * 
        if(row % 2 == 0){
            cellComponent.setBackground(Color.WHITE);
        } else{
            cellComponent.setBackground( Color.decode("#FFFFE0") );
        } 
        */
        
        /*
         * Pintar linhas de quatro-em-quatro
         *  Se divisão por quatro(0, 1, 2, 3)
         *  Se é Par: Pinta
         *  Se é Impar: não pinta
         *  Assim pinta de quatro em quatro
         *  
         */
        int iR = (int)row/4;
        if(iR % 2 == 0){ 
        	cellComponent.setBackground(Color.WHITE);
        }else{
        	cellComponent.setBackground( Color.decode("#EEEEE0") );        	
        }
        
        	
        return cellComponent;
    }
    		
	
 }