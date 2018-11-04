<html>
    <head>
        <title>Insert into RDF File</title>
        <?php
        include_once('stylesheet.html');
        $uniqID = substr(uniqid(),5,5);
        $voteid = "ontology_".$uniqID;
        ?>
    </head>

    <body>
        <main role="main">
            <div class="container">
                <br>
                <br>
                <form class="form-control" action="" method="POST">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-lg-12">
                                <label for="fileName">ชื่อไฟล์ของออนโทโลยี</label>
                                <input type="text" name="fileName" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-2">
                                <label for="startupID">ไอดีโหนดเริ่มต้น</label>
                                <input type="text" name="startupID" class="form-control" value="<?php echo $voteid; ?>"disabled/>
                            </div>
                            <div class="col-lg-4">
                                <label for="nameInsert">ชื่อของสิ่งของ</label>
                                <input type="text" name="nameInsert" class="form-control" placeholder="ควรเป็นภาษาอังกฤษเท่านั้น"/>
                            </div>
                            <div class="col-lg-4">
                                <label for="nameInsertURI">URI ชื่อของสิ่งของ</label>
                                <input type="text" name="nameInsertURI" class="form-control" placeholder="http://www.w3.org/Home/***"/>
                            </div>
                            <div class="col-lg-2">
                                <label for="resourceType">ประเภททรัพยากร</label>
                                <input type="text" name="resourceType" class="form-control" placeholder="s:**" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4">
                                <label for="URIanotherElement1">URI ของ องค์ประกอบอื่นๆ ที่ 1</label>
                                <input type="text" name="URIanotherElement1" class="form-control"/>
                            </div>
                            <div class="col-lg-4">
                                <label for="nameanotherElement1">ชื่อขององค์ประกอบอื่นๆที่ 1</label>
                                <input type="text" name="nameanotherElement1" class="form-control"/>
                            </div>
                            <div class="col-lg-2">
                                <label for="resourceType1">ประเภททรัพยากร</label>
                                <input type="text" name="resourceType1" class="form-control" placeholder="s:**" />
                            </div>
                            <div class="col-lg-2">
                                <label for="describe1">รายละเอียดอย่างย่อ</label>
                                <input type="text" name="describe1" class="form-control" placeholder="s:**" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4">
                                <label for="URIanotherElement2">URI ของ องค์ประกอบอื่นๆ ที่ 1</label>
                                <input type="text" name="URIanotherElement2" class="form-control"/>
                            </div>
                            <div class="col-lg-4">
                                <label for="nameanotherElement2">ชื่อขององค์ประกอบอื่นๆที่ 2</label>
                                <input type="text" name="nameanotherElement2" class="form-control"/>
                            </div>
                            <div class="col-lg-2">
                                <label for="resourceType2">ประเภททรัพยากร</label>
                                <input type="text" name="resourceType2" class="form-control" placeholder="s:**" />
                            </div>
                            <div class="col-lg-2">
                                <label for="describe2">รายละเอียดอย่างย่อ</label>
                                <input type="text" name="describe2" class="form-control" placeholder="s:**" />
                            </div>
                        </div>

                    </div>
                    <input type="submit" name="submit" class="form-control btn btn-success" value="ใส่ข้อมูล"/>
                </form>
            </div>
        </main>
    </body>
</html>
<?php
    if(isset($_POST['submit'])){
        define("RDFAPI_INCLUDE_DIR", "./api/");
        include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
        // Create a new MemModel
        $model = new MemModel();

        // Ceate new statements and add them to the model
        $firstNode = new Statement(
            new Resource($_POST['nameInsertURI']),
            new Resource("http://description.org/schema/Creator"),
            new BlankNode($voteid)
        );
        $secondNode = new Statement(
            new BlankNode($voteid),
            new Resource("http://www.w3.org/1999/02/22-rdf-syntax-ns#type"),
            new Resource("http://description.org/schema/".$_POST['resourceType'])
        );
        $thirdNode = new Statement(
            new BlankNode($voteid),
            new Resource("http://description.org/schema/".$_POST['resourceType1']),
            new Literal($_POST['nameanotherElement1'],"en")
        );
        $forthNode = new Statement(
            new BlankNode($voteid),
            new Resource("http://description.org/schema/".$_POST['resourceType2']),
            new Literal($_POST['nameanotherElement2'],"en")
        );
        $fifthNode = new Statement(
            new Resource($_POST['URIanotherElement1']),
            new Resource($_POST['nameanotherElement1']),
            new Literal($_POST['describe1'])
        );
        $sixthNode = new Statement(
            new Resource($_POST['URIanotherElement2']),
            new Resource($_POST['nameanotherElement2']),
            new Literal($_POST['describe2'])
        );

        $model->add($firstNode);
        $model->add($secondNode);
        $model->add($thirdNode);
        $model->add($forthNode);
        $model->add($fifthNode);
        $model->add($sixthNode);
        $model->saveAs($_POST['fileName'].".rdf");
    }
    ?>