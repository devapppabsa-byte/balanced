let nodo_arrastrado = null;

function dragStartPromedio(e){

    nodo_arrastrado = e.target;
    e.dataTransfer.setData('text', e.target.id);
    console.log(nodo_arrastrado)


}