function test(){
    confirmationContent.innerHTML = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur consequuntur iste vitae officia maiores aspernatur repellat harum porro nostrum nisi sint, debitis deserunt asperiores culpa cum placeat commodi totam fugiat soluta itaque aliquam? Laudantium, nostrum assumenda nemo maxime et magnam! <br> <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur consequuntur iste vitae officia maiores aspernatur repellat totam fugiat soluta itaque aliquam? Laudantium, nostrum assumenda nemo maxime et magnam! </br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur consequuntur iste vitae officia maiores aspernatur repellat harum porro nostrum nisi sint, debitis deserunt asperiores culpa cum placeat commodi totam fugiat soluta itaque aliquam? Laudantium, nostrum assumenda nemo maxime et magnam! <br> <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur consequuntur iste vitae officia maiores aspernatur repellat harum porro nostrum nisi sint, debitis deserunt asperiores culpa cum placeat commodi totam fugiat soluta itaque aliquam? Laudantium, nostrum assumenda nemo maxime et magnam! <br> <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur consequuntur iste vitae officia maiores aspernatur repellat harum porro nostrum nisi sint, debitis deserunt asperiores culpa cum placeat commodi totam fugiat soluta itaque aliquam? Laudantium, nostrum assumenda nemo maxime et magnam!  "
    confirmation.style.display = "block";
}

function fillOutAll(){
    fillOut("inputs1", "[type=text]", "Q8");
    fillOut("inputs2", "[type=email]", "thomas.d.s@hotmail.com");
    fillOut("inputs3", "textarea", "hej");
    let inputs4 = document.querySelectorAll("select");
    for(let i = 0; i < inputs4.length; i++){
        inputs4[i].value = inputs4[i].options[1].value;
    }
    fillOut("inputs5", "[name=firstDeadline]", "2020-12-01");
    fillOut("inputs6", "[name=finalDeadline]", "2020-12-21");
    fillOut("inputs7", "[name^=extraWidth],[name^=extraHeight]", "69");
}
function fillOut(tempVar, selector, input){
    tempVar = document.querySelectorAll(selector);
    for(let i = 0; i < tempVar.length; i++){
        tempVar[i].value = input;
    }
}