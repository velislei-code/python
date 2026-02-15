import java.awt.Graphics;


public class Linha {
/*	
	Reta r = new Reta();
	
	r.draw(g);
	
	public void draw(Graphics g){
		int x, y, erro, deltaX, deltaY;
		erro = 0;
		x = p1.x;
		y = p1.y;
		deltaX = p2.x - p1.x;
		deltaY = p2.y - p1.y;
 
		if((Math.abs(deltaY)>=Math.abs(deltaX) && p1.y>p2.y)
			||(Math.abs(deltaY)<Math.abs(deltaX) && deltaY<0)){
 
			x = p2.x;
			y = p2.y;
			deltaX = p1.x-p2.x;
			deltaY = p1.y-p2.y;
		}
		p1.draw(g);
		if(deltaX>=0){
			if(Math.abs(deltaX)>=Math.abs(deltaY)){
				for(int i=1;i<Math.abs(deltaX);i++){
					if(erro<0){
						x++;
						new Ponto(x,y).draw(g);
						erro += deltaY;
					}else{
						x++;
						y++;
						new Ponto(x,y).draw(g);
						erro += deltaY - deltaX;
					}
				}
			}else{
				for(int i=1;i<Math.abs(deltaY);i++){
					if(erro<0){
						x++;
						y++;
						new Ponto(x,y).draw(g);
						erro += deltaY - deltaX;						
					}else{
						y++;
						new Ponto(x,y).draw(g);
						erro -= deltaX;
					}
				}
			}
		}else{ // deltaX<0
			if(Math.abs(deltaX)>=Math.abs(deltaY)){
				for(int i=1;i<Math.abs(deltaX);i++){
					if(erro<0){
						x--;
						new Ponto(x,y).draw(g);
						erro += deltaY;
					}else{
						x--;
						y++;
						new Ponto(x,y).draw(g);
						erro += deltaY + deltaX;
					}
				}
			}else{
				for(int i=1;i<Math.abs(deltaY);i++){
					if(erro<0){
						x--;
						y++;
						new Ponto(x,y).draw(g);
						erro += deltaY + deltaX;						
					}else{
						y++;
						new Ponto(x,y).draw(g);
						erro += deltaX;
					}
				}
			}
		}
		p2.draw(g);
	}
	*/
}
