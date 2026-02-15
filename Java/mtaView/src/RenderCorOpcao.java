import java.awt.Color;
import java.awt.Component;

import javax.swing.JTable;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.TableCellRenderer;


class RenderCorOpcao extends DefaultTableCellRenderer 
{
private static final long serialVersionUID = 6703872492730589499L;
	
    public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column)
    {
        Component cellComponent = super.getTableCellRendererComponent(table, value, isSelected, hasFocus, row, column);
        
        if(table.getValueAt(row, column).equals("Não")){
            cellComponent.setBackground(Color.WHITE);
        }
        if(table.getValueAt(row, column).equals("Não")){
            cellComponent.setBackground(Color.decode("#D3D3D3"));
        }
        if(table.getValueAt(row, column).equals("Analisado")){
            cellComponent.setBackground(Color.GREEN);
        }
        
        
        return cellComponent;
    }
    
       

        
     
}