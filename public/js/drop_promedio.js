const promedio_container = document.getElementById('promedio_container'); 
const letrero_promedio = document.getElementById('letrero_promedio');

// variables de los campos de restas
const minuendo_container = document.getElementById('minuendo_container');
const sustraendo_container = document.getElementById('sustraendo_container');
//variables de los campos de restas


    let nodo_arrastrado = null;


    function dragStart(e){

    nodo_arrastrado = e.target;
    e.dataTransfer.setData('text', e.target.id);
    console.log("Aqui va la logica para cuando el nodo se empieza a arrastrar.")

    //Aqui tenemos el manejo de la UX XD
        promedio_container.classList.add("border-dashed");
        letrero_promedio.innerText= "Suelta el campo aqui debajo"
        letrero_promedio.classList.add("fw-bold");   
    //Manejo del DOM del container


    //el UX de los campos de resta minuendo y sustraendo
        minuendo_container.classList.add("border-dashed");
        sustraendo_container.classList.add("border-dashed");
        sustraendo_container.classList.remove("border");
        minuendo_container.classList.remove("border");

    //el UX de los campos de resta minuendo y sustraendo

    }


    function allowDrop(e){
        e.preventDefault();

    }




    function drop(e){

        console.log('Aqui va la logica para cuando se suelta el nodo')

        //UX del campo de promedio
        promedio_container.classList.remove('border-dashed');
        letrero_promedio.innerText = "Arrastra los campos a promediar";
        //UX del campo promedio termina aqui



        //UX del campo de restas la ctm
        minuendo_container.classList.remove('border-dashed');
        sustraendo_container.classList.remove('border-dashed');
        minuendo_container.classList.add('border');
        sustraendo_container.classList.add('border');
        //UX del campo de restas la ctm, termina aqui





        e.preventDefault();



        if(nodo_arrastrado){


            let destino = e.target;
            const id = e.dataTransfer.getData('text');


            if(!destino.classList.contains('no-drop')){
                destino.appendChild(nodo_arrastrado);
            }

        }
    }
