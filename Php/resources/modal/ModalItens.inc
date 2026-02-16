  <!-- ======================================= Begin Modal Itens ==================================== -->  
    <div class="modal fade" id="ModalConfigItens" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="ModalLabel">Configurar Itens</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="col-md-6 form-group mt-3 mt-md-0"> 
            
              <div class="max-width">
              <i class="bi bi-house-gear"></i>
                <span><?Php  echo $NomeAnuncioAtual; ?></span>          
              </div>


              <div class="max-width"><span>Banho</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Banheira" id="ckBoxBanheira">
                <i class="fa fa-bath" aria-hidden="true"></i>
                <img src="assets/icons/bathtub-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Banheira</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="SecCabelo" id="ckBoxSecCabelo">
                <img src="assets/icons/hairdryer-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Sec.Cabelo</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Shampoo" id="ckBoxShampoo">
                <img src="assets/icons/shampoo-bottle-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Shampoo</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Condiciona" id="ckBoxCondiciona">
                <img src="assets/icons/beauty-perfume-spray-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Condicionador</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Toalha" id="ckBoxToalha">
                <label class="form-check-label" for="flexCheckDefault">Toalha</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Agua-quente" id="ckBoxAguaQuente">
                <label class="form-check-label" for="flexCheckDefault">Agua-quente</label>
              </div>

              <div class="max-width"><span>Lavanderia</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Maq.Lavar" id="ckBoxMaqLavar">
                <img src="assets/icons/clothes-washing-icon.svg" alt="" width="16" height="16" title=""> 
                <label class="form-check-label" for="flexCheckDefault">Maq.Lavar</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Secadora" id="ckBoxSecadora">
                <label class="form-check-label" for="flexCheckDefault">Secadora</label>
              </div>

              <div class="max-width"><span>Quarto</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Roupa-de-cama" id="ckBoxRoupaCama">
                <label class="form-check-label" for="flexCheckDefault">Roupa de cama</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Travesseiro" id="ckBoxTravesseiroExt">
                <label class="form-check-label" for="flexCheckDefault">Travesseiro extra</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Cobertor" id="ckBoxCobertorExt">
                <label class="form-check-label" for="flexCheckDefault">Cobertor extra</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Cabide" id="ckBoxCabide">
                <img src="assets/icons/hanger-towel-icon.svg" alt="" width="16" height="16" title=""> 
                <label class="form-check-label" for="flexCheckDefault">Cabides</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Ferro" id="ckBoxFerro">
                <img src="assets/icons/iron-icon.svg" alt="" width="16" height="16" title=""> 
                <label class="form-check-label" for="flexCheckDefault">Ferro de passar</label>
              </div>

              <div class="max-width"><span>Escritorio</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Wifi" id="ckBoxWifi">
                <i class="bi bi-wifi"></i>
                <label class="form-check-label" for="flexCheckDefault">Wifi</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="TvCabo" id="ckBoxTvCabo">
                <img src="assets/icons/television-icon.svg" alt="" width="16" height="16" title="">  
                <label class="form-check-label" for="flexCheckDefault">Tv.cabo/Netflix</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="MesaNoteBook" id="ckBoxMesaNote">
                <img src="assets/icons/office-chair-icon.svg" alt="" width="16" height="16" title="">  
                <label class="form-check-label" for="flexCheckDefault">Mesa p/ notebook</label>
              </div>


              <div class="max-width"><span>Conforto</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Ar-Condicionado" id="ckBoxArCondicionado">
                <img src="assets/icons/air-conditioner-icon.svg" alt="" width="16" height="16" title="">  
                <label class="form-check-label" for="flexCheckDefault">Ar condicionado</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Ventilador" id="ckBoxVentilador">
                <i class="bi bi-fan"></i>
                <label class="form-check-label" for="flexCheckDefault">Ventiladores</label>
              </div>              
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Ventilador-teto" id="ckBoxVentiladorTeto">
                <img src="assets/icons/ceiling-fan-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Vent.Teto</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Aquecedor-Central" id="ckBoxAquecedorCentral">
                <label class="form-check-label" for="flexCheckDefault">Aquecedor central</label>
              </div>

              <div class="max-width"><span>Segurança</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Detec.Fumaca" id="ckBoxDetecFumaca">
                <label class="form-check-label" for="flexCheckDefault">Detector Fumaça</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Detec.Monoxido" id="ckBoxDetecMonoxido">
                <label class="form-check-label" for="flexCheckDefault">Detector monoxido</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Extintor" id="ckBoxExtintor">
                <i class="fas fa-fire-extinguisher"></i>                
                <label class="form-check-label" for="flexCheckDefault">Extintor</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Kit-Pri-Socorro" id="ckBoxPriSocorro">
                <label class="form-check-label" for="flexCheckDefault">Kit prim.socorros</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Fech.intelig." id="ckBoxFechaSmart">
                <img src="assets/icons/smart-wireless-door-lock-icon.svg" alt="" width="16" height="16" title="">                  
                <label class="form-check-label" for="flexCheckDefault">Fech.inteligente</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Camera" id="ckBoxCamera">
                <i class="bi bi-camera-video"></i>
                <label class="form-check-label" for="flexCheckDefault">Camera</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Cofre" id="ckBoxCofre">
                <img src="assets/icons/locker-icon.svg" alt="" width="16" height="16" title="">                    
                <label class="form-check-label" for="flexCheckDefault">Cofre</label>
              </div>
             
              <div class="max-width"><span>Cozinha</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Itens-Cozinha" id="ckBoxItensCoz">
                <img src="assets/icons/dishes-icon.svg" alt="" width="16" height="16" title="">  
                <label class="form-check-label" for="flexCheckDefault">Itens de cozinha</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Talheres" id="ckBoxTalheres">
                <img src="assets/icons/food-restaurant-icon.svg" alt="" width="16" height="16" title="">  
                <label class="form-check-label" for="flexCheckDefault">Talheres</label>
              </div>            
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Micro-ondas" id="ckBoxMicroOndas">
                <img src="assets/icons/microwave-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Micro ondas</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Refrigerador" id="ckBoxRefrigerador">
                <img src="assets/icons/snow2.svg" alt="" width="16" height="16" title=""> 
                <label class="form-check-label" for="flexCheckDefault">Refrigerador</label>
              </div>             
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Frezzer" id="ckBoxFrezzer">
                <img src="assets/icons/snow3.svg" alt="" width="16" height="16" title=""> 
                <label class="form-check-label" for="flexCheckDefault">Frezzer</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Lava-loucas" id="ckBoxLavaLouca">
                <label class="form-check-label" for="flexCheckDefault">Lava louças</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Fogao" id="ckBoxFogao">
                <img src="assets/icons/kitchen-stove-cooking-pot-non-stick-icon.svg" alt="" width="16" height="16" title=""> 
                <label class="form-check-label" for="flexCheckDefault">Fogao</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Forno" id="ckBoxForno">
                <label class="form-check-label" for="flexCheckDefault">Forno</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Chaleira" id="ckBoxChaleira">
                <img src="assets/icons/electric-kettle-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Chaleira(elét)</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Cafeteira" id="ckBoxCafeteira">
                <img src="assets/icons/coffee-machine-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Cafeteira</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Torradeira" id="ckBoxTorradeira">
                <img src="assets/icons/.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Torradeira</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Liquidificador" id="ckBoxLiquidificador">
                <img src="assets/icons/kitchen-mixer-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Liquidificador</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Churrasqueira" id="ckBoxChurrasqueira">
                <img src="assets/icons/bbq-icon.svg" alt="" width="16" height="16" title=""> 
                <label class="form-check-label" for="flexCheckDefault">Churrasqueira</label>
              </div>

              <div class="max-width"><span>Acessos</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Sacada" id="ckBoxSacada">
                <img src="assets/icons/.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Sacada</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Piscina" id="ckBoxPiscina">
                <img src="assets/icons/pool-ladder-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Piscina</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Academia" id="ckBoxAcademia">
                <img src="assets/icons/ gym-workout-spinning-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Academia</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Cadeirante" id="ckBoxCadeirante">
                <img src="assets/icons/person-wheelchair.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Acesso Cadeirante</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Estacionamento" id="ckBoxEstacionamento">
                <img src="assets/icons/car-icon.svg" alt="" width="16" height="16" title="">                
                <label class="form-check-label" for="flexCheckDefault">Estacionamento</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Carregador-eletrico" id="ckBoxCarregador">
                <i class="bi bi-ev-station"></i>
                <label class="form-check-label" for="flexCheckDefault">Carregador eletrico</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Acesso-Praia" id="ckBoxAcessoPraia">
                <img src="assets/icons/island-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Acesso a praia</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Vista-Praia" id="ckBoxVistaPraia">
                <img src="assets/icons/sunrise-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Vista Praia</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Itens-praia" id="ckBoxItensPraia">
                <img src="assets/icons/beach-umbrella-icon.svg" alt="" width="16" height="16" title="">
                <label class="form-check-label" for="flexCheckDefault">Itens de praia</label>
              </div>

              <div class="max-width"><span>Permissões</span></div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="DEixar-malas" id="ckBoxDeixarMalas">
                <i class="bi bi-suitcase"></i>
                <label class="form-check-label" for="flexCheckDefault">Deixar malas</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Estadia-longa" id="ckBoxEstadiaLonga">
                <i class="bi bi-luggage"></i>
                <label class="form-check-label" for="flexCheckDefault">Estadias longas</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Auto-checkin" id="ckBoxAutoCheckIn">
                <label class="form-check-label" for="flexCheckDefault">Auto check-in</label>
              </div>
              

              <div class="max-width">
                <!-- <input type="text" class="form-control" name="EdDescPicture" id="EdDescPicture" placeholder="Description picture" value="<?Php echo $EdDescPictureX; ?>" onchange="peguePathFiles(this.value);" required> 
                <button type="submit" name="btnAdd" id="btnAdd" class="form-submit-button" onclick="addImgList();">Add</button> -->
              </div>

            </div>
          </div>
      
          <div class="modal-footer">
            <button type="button" class="form-submit-button-sm" data-bs-dismiss="modal">Fechar</button>          
            <button type="button" class="form-submit-button-sm" data-bs-dismiss="modal" onclick="checkBoxToLista();">Salvar</button>          
          </div>
        </div>
      </div>
    </div>
    <!-- ============================== End Modal Pictures =============================================== -->
  