<?php
/*Création de la base donnée
Create database WEBPROJECT;

Use WEBPROJECT;

create table PROFIL
(
PROFIL_ID Integer Not Null auto_increment,
PROFIL_LASTNAME Varchar(15) Not Null,
PROFIL_FIRSTNAME Varchar(15) Not Null,
PROFIL_LOGIN Varchar(15) Not Null,
PROFIL_PASSWORD Varchar(60) Not Null,
PROFIL_IMG_LOCATION Varchar(100) Not Null,
USERNAME Varchar(15) Not Null,
PASSWORD Varchar(60) Not Null,
constraint PROFIL_PK primary key(PROFIL_ID),
)
;

create table DESCRIPTION_TABLE
(
DESCRIPTION_ID Integer Not Null auto_increment,
DESCRIPTION Varchar(4000) Not Null,
PROFIL_ID Integer Not Null,
constraint DESCRIPTION_PK primary key(DESCRIPTION_ID),
constraint DESCRIPTION_FK foreign key (PROFIL_ID)
references PROFIL(PROFIL_ID)
)
;

create table FORMATION
(
FORMATION_ID Integer Not Null auto_increment,
FORMATION_NAME Varchar(100) Not Null,
FORMATION_DETAILS Varchar(100) Not Null,
FORMATION_YEAR Varchar(100) Not Null,
FORMATION_IMG_LOCATION Varchar(100) Not Null,
PROFIL_ID Integer Not Null,
constraint FORMATION_PK primary key(FORMATION_ID),
constraint FORMATION_FK foreign key (PROFIL_ID)
references PROFIL(PROFIL_ID)
)
;

create table PROFESSIONAL_EXP
(
PRO_EXP_ID Integer Not Null auto_increment,
PRO_EXP_NAME Varchar(100) Not Null,
PRO_EXP_DETAILS Varchar(100) Not Null,
PRO_EXP_YEAR Varchar(100) Not Null,
PRO_EXP_IMG_LOCATION Varchar(100) Not Null,
PROFIL_ID Integer Not Null,
constraint PRO_EXP_PK primary key(PRO_EXP_ID),
constraint PRO_EXP_FK foreign key (PROFIL_ID)
references PROFIL(PROFIL_ID)
)
;

create table SKILL_COLUMN
(
SKILL_COLUMN_ID Integer Not Null auto_increment,
SKILL_NAME Varchar(20) Not Null,
PROFIL_ID Integer Not Null,
constraint SKILL_NAME_PK primary key(SKILL_COLUMN_ID),
constraint SKILL_COLUMN_ID_FK foreign key (PROFIL_ID)
references PROFIL(PROFIL_ID)
)
;

create table SKILL_IMG
(
SKILL_IMG_ID Integer Not Null auto_increment,
SKILL_IMG_LOCATION varchar(100) Not Null,
SKILL_COLUMN varchar(20) Not Null,
PROFIL_ID Integer Not Null,
constraint IMG_SKILL_PK primary key(IMG_SKILL_ID),
constraint IMG_SKILL_FK1 foreign key (SKILL_COLUMN)
references SKILL_COLUMN(SKILL_COLUMN_ID),
constraint IMG_SKILL_ID_FK2 foreign key (PROFIL_ID)
references PROFIL(PROFIL_ID),
)
;

create table HOBBIES
(
HOBBY_ID Integer Not Null auto_increment,
HOBBY_IMG_LOCATION Varchar(100) Not Null,
PROFIL_ID Integer Not Null,
constraint HOBBIES_PK primary key(HOBBIES_ID),
constraint HOBBIES_FK foreign key (PROFIL_ID)
references PROFIL(PROFIL_ID)
)
;

create table COLOR
(
COLOR_ID Integer Not Null auto_increment,
COLOR_NAME Varchar(20) Not Null,
HEXA_CODE Varchar(7),
PROFIL_ID Integer Not Null,
constraint COLOR_PK primary key(COLOR_ID),
constraint COLOR_FK foreign key (PROFIL_ID)
references PROFIL(PROFIL_ID)
)
;

 */

function add_profil_DB($profil_lastname, $profil_firstname, $profil_login, $profil_password, $profil_img_location) //fonction qui ajoute un profil à la base de donnée
{
  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //option affichage erreurs pour PDO

  $stmt = $pdo->prepare("INSERT INTO PROFIL VALUES(NULL, :PROFIL_LASTNAME, :PROFIL_FIRSTNAME, :LOGIN, :PASSWORD, :PROFIL_IMG_LOCATION)");
  $stmt->execute(array(
  "PROFIL_LASTNAME" => $profil_lastname,
  "PROFIL_FIRSTNAME" => $profil_firstname,
  "LOGIN" => $profil_login,
  "PASSWORD" => password_hash($profil_password, PASSWORD_DEFAULT),
  "PROFIL_IMG_LOCATION" => $profil_img_location
  ));
}


function connexion() // fonction qui permet à un utilisateur de se connecter
{
  if(isset($_POST["login"]) && isset($_POST["password"])) //Test si champs remplis
  {
      $login = $_POST["login"];
      $password = $_POST["password"];

      $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->prepare("SELECT * FROM PROFIL WHERE LOGIN = :LOGIN");
      $stmt->execute(array(
          "LOGIN" => $login
      ));
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if($user)
      {
          if(password_verify($password, $user["PASSWORD"]))
          {
  			      $_SESSION["profil_ID"] = $user["PROFIL_ID"];
  			      header('Location:admin_page.php');
          }
          else
          {
              echo "Mot de passe incorrect";
          }
      }
      else
      {
          echo "Aucun compte avec ce login";
      }
  }
}


function add_description_DB($profil_ID) //ajoute la description saisie à la base de donnée en fonction de l'utilisateur en parametre.
{
  if(isset($_POST["who_am_I"]))
  {
  $description = $_POST["who_am_I"];

  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("INSERT INTO DESCRIPTION_TABLE VALUES(NULL, :DESCRIPTION, :PROFIL_ID)");
  $stmt->execute(array(
   "DESCRIPTION" => $description,
   "PROFIL_ID" => $profil_ID,
    ));
   }
}


function add_formation_DB($profil_ID) //ajoute la formation saisie à la base de donnée en fonction de l'utilisateur en parametre.
{
  if(isset($_FILES["formation_img"]) && isset($_POST["school_name"]) && isset($_POST["formation_name"]) && isset($_POST["formation_year"]))
  {
  $school_name = $_POST["school_name"];
  $formation_name = $_POST["formation_name"];
  $formation_year = $_POST["formation_year"];

  $source = $_FILES["formation_img"]["tmp_name"];
  $destination = __DIR__ . ".." . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $source . ".png";

  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("INSERT INTO FORMATION VALUES(NULL, :FORMATION_NAME, :FORMATION_DETAILS, :FORMATION_YEAR, :FORMATION_IMG_LOCATION, :PROFIL_ID)");
  $stmt->execute(array(
    "FORMATION_NAME" => $school_name,
    "FORMATION_DETAILS" => $formation_name,
    "FORMATION_YEAR" => $formation_year,
    "FORMATION_IMG_LOCATION" => $destination,
    "PROFIL_ID" => $profil_ID,
    ));

  move_uploaded_file($source, $destination);
  }
}


function add_exp_pro_DB($profil_ID) //ajoute l'experience professionnelle saisie à la base de donnée en fonction de l'utilisateur en parametre.
{
  if(isset($_FILES["pro_exp_img"]) && isset($_POST["pro_exp_name"]) && isset($_POST["pro_exp_details"]) && isset($_POST["pro_exp_year"]))
  {
  $pro_exp_name = $_POST["pro_exp_name"];
  $pro_exp_details = $_POST["pro_exp_details"];
  $pro_exp_year = $_POST["pro_exp_year"];

  $source = $_FILES["pro_exp_img"]["tmp_name"];
  $destination = __DIR__ . ".." . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $source . ".png";

  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("INSERT INTO PROFESSIONAL_EXP VALUES(NULL, :PRO_EXP_NAME, :PRO_EXP_DETAILS, :PRO_EXP_YEAR, :PRO_EXP_IMG_LOCATION, :PROFIL_ID)");
  $stmt->execute(array(
    "PRO_EXP_NAME" => $pro_exp_name,
    "PRO_EXP_DETAILS" => $pro_exp_details,
    "PRO_EXP_YEAR" => $pro_exp_year,
    "PRO_EXP_IMG_LOCATION" => $destination,
    "PROFIL_ID" => $profil_ID,
    ));

  move_uploaded_file($source, $destination);
  }
}


function add_skill_column_DB($profil_ID) //ajoute la colonne saisie à la base de donnée en fonction de l'utilisateur en parametre.
{
  if(isset($_POST["new_categorie_name"])
  {
      $new_categorie_name = $_POST["new_categorie_name"];

      $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->prepare("INSERT INTO SKILL_COLUMN VALUES(NULL, :SKILL_NAME, :PROFIL_ID)");
      $stmt->execute(array(
        "SKILL_NAME" => $new_categorie_name,
        "PROFIL_ID" => $profil_ID,
        ));
  }
}


function add_skill_img_DB($profil_ID) //ajoute l'image saisie à la base de donnée en fonction de l'utilisateur en parametre.
{
  if(isset($_POST["skill_img_column"] && $_FILES["skill_img"])
  {
      $skill_img_column = $_POST["skill_img_column"];

      $source = $_FILES["skill_img"]["tmp_name"];
      $destination = __DIR__ . ".." . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $source . ".png";

      $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->prepare("INSERT INTO SKILL_IMG VALUES(NULL, :SKILL_IMG_LOCATION, :SKILL_COLUMN, :PROFIL_ID)");
      $stmt->execute(array(
        "SKILL_IMG_LOCATION" => $destination,
        "SKILL_COLUMN" => $skill_img_column,
        "PROFIL_ID" => $profil_ID,
        ));

      move_uploaded_file($source, $destination);
  }
}


function add_hobby_DB($profil_ID) ////ajoute l'activité saisie à la base de donnée en fonction de l'utilisateur en parametre.
{
  if(isset($_FILES["hobby_img"]))
  {
      $source = $_FILES["hobby_img"]["tmp_name"];
      $destination = __DIR__ . ".." . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $source . ".png";

      $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->prepare("INSERT INTO HOBBIES VALUES(NULL, :HOBBY_IMG_LOCATION, :PROFIL_ID)");
      $stmt->execute(array(
        "HOBBY_IMG_LOCATION" => $destination,
        "PROFIL_ID" => $profil_ID,
        ));

      move_uploaded_file($source, $destination);
  }
}


function get_description($profil_ID) // getteur de la description en fonction de l'utilisateur
{
  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT DESCRIPTION FROM DESCRIPTION_TABLE WHERE PROFIL_ID = :PROFIL_ID");
  $stmt->execute(array(
    "PROFIL_ID" => $profil_ID,
    ));

  $description = $stmt->fetchAll();
  return $description;
}


function get_formations($profil_ID) // getteur des formations en fonction de l'utilisateur
{
  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT * FROM FORMATION WHERE PROFIL_ID = :PROFIL_ID");
  $stmt->execute(array(
    "PROFIL_ID" => $profil_ID,
    ));

  $formations = $stmt->FETCH_ASSOC();
  return $formations;
}


function get_professional_exp($profil_ID) // getteur des exp pro en fonction de l'utilisateur
{
  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT * FROM PROFESSIONAL_EXP WHERE PROFIL_ID = :PROFIL_ID");
  $stmt->execute(array(
    "PROFIL_ID" => $profil_ID,
    ));

  $professional_exp = $stmt->FETCH_ASSOC();
  return $professional_exp;
}


function get_skill_column_name($profil_ID) // getteur des colonnes de compétences en fonction de l'utilisateur
{
  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT SKILL_NAME FROM SKILL_COLUMN WHERE PROFIL_ID = :PROFIL_ID");
  $stmt->execute(array(
    "PROFIL_ID" => $profil_ID,
    ));

  $skill_column_name = $stmt->FETCH_ASSOC();
  return $skill_column_name;
}


function get_skill_img($profil_ID) // getteur des images des competences en fonction de l'utilisateur
{
  $skill_column_name = get_skill_column_name($profil_ID);

  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT SKILL_IMG_LOCATION FROM SKILL_IMG WHERE SKILL_NAME IS LIKE :SKILL_NAME AND PROFIL_ID = :PROFIL_ID");
  $stmt->execute(array(
    "SKILL_NAME" => $skill_column_name,
    "PROFIL_ID" => $profil_ID,
    ));

  $skill_img = $stmt->FETCH_ASSOC();
  return $skill_column_name;
}


function get_hobbies_img($profil_ID) // getteur des hobbies en fonction de l'utilisateur
{
  $pdo = new PDO("mysql:host=localhost:3306;dbname=WEBPROJECT", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT HOBBY_IMG_LOCATION FROM HOBBIES WHERE PROFIL_ID = :PROFIL_ID");
  $stmt->execute(array(
    "PROFIL_ID" => $profil_ID,
    ));

  $hobby_img = $stmt->FETCH_ASSOC();
  return $hobby_img;
}


 ?>
