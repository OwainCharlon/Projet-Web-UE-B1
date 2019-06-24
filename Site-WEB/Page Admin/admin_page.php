<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Page admin</title>
    <link rel="stylesheet" href="css/aaaa.css">
    <link rel="stylesheet" href="css/nullify.css">
  </head>

  <body>

    <header>
      <nav>

      <!--  Navbar -->

        <div class="navbar">

          <div class="profile">
            <img id ="profile-picture" src="images/p1.jpg" alt="">
            <h1>Dylan Levraud</h1>
          </div>

          <div class="menu">

            <ul>
              <li><a href="#description">Qui suis-je ?</a></li>
              <li><a href="#section-sc">Parcours</a></li>
              <li><a href="#section-exp">Experiences Professionnelles</a></li>
              <li><a href="#section-comp">Competences</a></li>
              <li><a href="#section-hobbies">Hobbies</a></li>
            </ul>

          </div>

        </div>
      </nav>
    </header>


    <main>
      <!--Section à gauche de la navbar  -->
      <section id="modification_form_of_profil_page">
            <br><br>
            <!-- Formulaire Qui suis-je -->
            <legend class="legend"><span class="number">1</span> QUI SUIS-JE ?</legend>
            <form class="form" action="admin_page.php" method="post">
              <label for="who_am_I">Profil</label>
                <textarea name="who_am_I" value="" placeholder="Saisissez la description de votre choix." rows="15" cols="80"></textarea>
                <input type="submit" name="" value="Mettre a jour mon profil">
            </form>
              <br><br>

            <!--  Formulaire Parcours Scolaire-->
          <legend class="legend"><span class="number">2</span> PARCOURS SCOLAIRE </legend>
          <form class="form" action="admin_page.php" method="post" enctype="multipart/form-data">
            <label for="formation_img" >Photo liee a la formation</label>
            <input type="file" value="" name="formation_img"
            placeholder="Inserer le lien de la photo de la formation que vous souhaitez ajouter." accept="">
            <label for="school_name">Etablissement frequente</label>
            <input type="text" name="school_name" value="" placeholder="Indiquer le nom de l'etablissement que vous souhaitez ajouter.">
            <label for="formation_name">Nom de la formation</label>
            <input type="text" name="formation_name" value="" placeholder="Indiquer le nom de la formation a ajouter.">
            <label for="formation_year">Annee / duree de la formation</label>
            <input type="text" name="formation_year" value="" placeholder="Indiquer l'annee ou la duree de la formation a ajouter.">
            <input type="submit" name="" value="Ajouter une formation">
          </form>
            <br><br>

            <!--  Formulaire Experiences  professionnelles-->
          <legend class="legend" ><span class="number">3</span> EXPERIENCES PROFESIONNELLES </legend>
          <form class="form" action="admin_page.php" method="post" enctype="multipart/form-data">
            <label for="pro_exp_img">Photo liee a l'experience professionnelle</label>
            <input type="file" value="" name="pro_exp_img"
            placeholder="Inserer le lien de la photo liee a l'experience professionnelle que vous souhaitez ajouter." accept="">
            <label for="pro_exp_name">Nom de l'entreprise frequentee</label>
            <input type="text" name="pro_exp_name" value="" placeholder="Indiquer le nom de l'entreprise frequentee a ajouter.">
            <label for="pro_exp_details">Enonce de l'experience</label>
            <input type="text" name="pro_exp_details" value="" placeholder="Indiquer l'enonce de l'experience professionnelle à ajouter.">
            <label for="pro_exp_year">Annee / duree de l'experience professionnelle</label>
            <input type="text" name="pro_exp_year" value="" placeholder="Indiquer l'annee ou la duree de l'experience professionnelle a ajouter.">
            <input type="submit" name="" value="Ajouter une experience professionnelle">
          </form>
            <br><br>

            <!--  Formulaire Compétences-->
          <legend class="legend"><span class="number">4</span> COMPETENCES </legend>
          <form class="form" action="admin_page.php" method="post">
            <label for="new_categorie_name">1/ Ajouter une rubrique de competence</label>
            <input type="text" name="new_categorie_name" value="" placeholder="Ajouter un nom a la rubrique qui va etre creee.">
          </form>
          <a title="add_skills_categorie" href="admin_page.php" id="add_skills_categorie_button">Ajouter une rubrique</a>
          <br><br><br><br>


          <form class="form" action="admin_page.php" method="post">
            <label for="skill_img_column">2/ Choisissez la rubrique/colonne au sein de laquelle ajouter cette competence</label>
            <input type="text" name="skill_img_column" value="" placeholder="Ajouter la rubrique/colonne de l'image a ajouter.">
            <label for="skill_img">3/ Photo liee a la competence</label>
            <input type="file" name="skill_img" value="" placeholder="Inserer Inserer le lien de la photo liee a la competence que vous souhaitez.">
            <input type="submit" name="" value="Ajouter une competence">
          </form>
            <br><br>

            <!--  Formulaire Hobbies -->
          <legend class="legend"><span class="number">5</span> HOBBIES </legend>
          <form class="form" action="admin_page.php" method="post" enctype="multipart/form-data" >
            <label for="hobby_img">Photo liee au hobby</label>
            <input type="file" multiple value="" name="hobby_img"
            placeholder="Inserer le lien de la photo du hobby que vous souhaitez ajouter." accept="">
            <input type="submit" name="" value="Ajouter un hobby">
          </form>
            <br><br>
      </section>
    </main>

  </body>


</html>
