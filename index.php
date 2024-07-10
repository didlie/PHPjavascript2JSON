<?php


    function js2jSON($jsCode) {
        // Regular expression to match function declarations and object properties
        $pattern = '/(?:function\s+(\w+)\s*\(|(\w+)\s*:\s*function\s*\(|(\w+)\s*:\s*{\s*function\s*)/';
    
        preg_match_all($pattern, $jsCode, $matches);
    
        $result = [];
        foreach ($matches[1] as $functionName) {
            $result['functions'][] = $functionName;
        }
        foreach ($matches[2] as $propertyName) {
            $result['properties'][] = $propertyName;
        }
        foreach ($matches[3] as $propertyName) {
            $result['properties'][] = $propertyName;
        }
    
        // Include the original JavaScript code
        $result['jsCode'] = $jsCode;
    
        return json_encode($result, JSON_PRETTY_PRINT);
    }




//function to validate input
function checkJsCodePost() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['jsCode']) && !empty($_POST['jsCode'])) {
            // The jsCode value is present and not empty
            return true;
        } else {
            // The jsCode value is missing or empty
            return false;
        }
    } else {
        // Not a POST request
        return false;
    }
}
//


// Example usage:// Example usage:
if (checkJsCodePost()) {
    echo js2jSON($_POST["jsCode"]);
    die;
    //simplest out
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
        <form action="" method="post">
            <textarea name="jsCode" placeholder="Enter JavaScript code here"></textarea>
            <button type="submit">js2JSON</button>
        </form>
    </div>
</body>
</html>

