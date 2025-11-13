let nodo_arrastrado_porcentaje = null;


function dragStartPorcentaje(e){

    nodo_arrastrado_porcentaje = e.target;
    e.dataTransfer.setData('text', e.target.id);

    


}