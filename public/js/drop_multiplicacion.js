const multiplicacion_container = document.getElementById("multiplicacion_container");

const letrero_multiplicacion = document.getElementById("letrero_multiplicacion");

let nodo_arrastrado_multiplicacion = null;



function dragStartMultiplicacion(e){


    nodo_arrastrado_multiplicacion = e.target;
    e.dataTransfer.setData('text', e.target.id);
    multiplicacion_container.classList.add("border-dashed");
    letrero_multiplicacion.innerHTML = "<b> Suelta el campo aqui debajo </b>"



}

function allowDropMultiplicacion(e){
    
    e.preventDefault();

}


function dropMultiplicacion(e){


    multiplicacion_container.classList.remove('border-dashed');
    letrero_multiplicacion.innerText = "Arrastra los campos a multiplicar";

    e.preventDefault();


    if(nodo_arrastrado_multiplicacion){

        const existe = Array.from(AudioDestinationNode.children).some(child => child.dataset.originalId === id);


        if(existe){
            alert('El campo ya fue agregado anteriormente. !')
            return;
        }

        const copia = nodo_arrastrado_multiplicacion.cloneNode(true);


        copia.dataset.originalId = id;
        AudioDestinationNode.appendChild(copia);


    }


}