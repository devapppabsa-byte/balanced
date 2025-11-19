let nodo_arrastrado_porcentaje = null;
const parte_container = document.getElementById('parte_container');
const total_container = document.getElementById('total_container');


function dragStartPorcentaje(e){

    nodo_arrastrado_porcentaje = e.target;
    e.dataTransfer.setData('text', e.target.id);

    parte_container.classList.add("border-dashed");
    parte_container.classList.remove('border');

    total_container.classList.add("border-dashed");
    total_container.classList.remove("border");


}


function allowDropPorcentaje(e){

    e.preventDefault();

}


function dropPorcentaje(e){

    parte_container.classList.remove("border-dashed");
    parte_container.classList.add("border");

    total_container.classList.remove("boder-dashed");
    total_container.classList.add("border");


    e.preventDefault();

    if(nodo_arrastrado_porcentaje){
        
        let destino = e.target;
        
        if(!destino.classList.contains('no-drop')){
            destino.innerHTML = "";
            const copia = nodo_arrastrado_porcentaje.cloneNode(true);
            destino.appendChild(copia);
        }

    }

}