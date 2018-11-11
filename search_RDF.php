<html>
<head>
    <title>Search</title>
</head>
<body>
    <table border="1">
        <tr>
            <td>
                Search :
            </td>
            <td>
                <form method="POST" action="">
                    <input type="text" name="searchString">
                    <input type="submit" name="submit">
                </form>
            </td>
        </tr>
    </table>
</body>
</html>
<?php
if(isset($_POST['submit'])){
    define("RDFAPI_INCLUDE_DIR", "./api/");
    include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
    // Create a new MemModel
    $model = new MemModel();
    // Filename of an RDF document
    $base="SUT_Subject_MEC.owl";

// Load and parse document
    $model->load($base);
    echo $_POST['searchString'];
    $homepage = new Resource("http://www.semanticweb.org/jiraista/ontologies/2018/8/untitled-ontology-6#".$_POST['searchString']);
    $searchString = $model->find($homepage, NULL, NULL);
    $searchString->writeAsHtmlTable();
    echo "<P>";
}

?>