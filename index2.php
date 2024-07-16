<?php
/**********************IT WORKS******************************** */
/*********** FUNCTIONS IN FILES MUST BE WRITTEN AS **************/
/**window.functionName = function() { something here...} ********/
/********to be eval() in the window scope ***********************/
/************************************************************** */

//the other functions were my method for spliting the function name
//and function body to make it easier to assign the name to window
//and eval() the body

//function to validate input
function checkJsCodePost() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = file_get_contents('php://input');
            $json_data = json_decode($data, true);
            file_put_contents("jsCode.js",$json_data);
        return true;
    } else {
        return false;
    }
}
// Example usage:// Example usage:
if (checkJsCodePost()) {
    echo json_encode(file_get_contents("jsCode.js"));
    die;
    //simplest out
}else{
    //stop caching during tests
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>js2JSON Form</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }
        .form-container textarea {
            width: 100%;
            height: 200px;
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px;
            box-sizing: border-box;
        }
        .form-container button {
            width: 100%;
            background-color: #0074d9;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- <form action="" method="post"> -->

            <textarea id = "jsCode" name="jsCode" placeholder="Enter JavaScript code here"></textarea>
            <button id='submit' type="submit">js2JSON</button>
        <!-- </form> -->
    </div>
    <script>
/**************************script content*********************** */
/*************************************************************** */
/*********************fetch and eval *************************** */
    function globalVariableRequest(){
    let code = document.getElementById("jsCode").value;
    fetch("", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ "evalThis": code }) 
    })
    .then(response => response.text())
    .then(data => {
        const evalThis = JSON.parse(data);
        // console.log(evalThis);
        eval(evalThis);
    })
    .catch((error) => { console.log(error);});
    }


    /************************************************** */
   /**LISTEN TO THE BUTTON TO SUBMIT THE JAVASCRIPT CODE */
   /**REMEMBER window.functionName = function(){  ...  } */ 
   /**************************************************** */


    document.getElementById('submit').addEventListener('click', function(event) {
    // Prevent the form from submitting
    event.preventDefault();
    // Call your function
    globalVariableRequest();
});



    </script>
</body>
</html>
