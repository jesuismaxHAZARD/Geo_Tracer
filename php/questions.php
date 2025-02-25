<?php session_start(); ?>
<?php

class Quiz
{
    public function get_questions()
    {   
        $db = include_once('dbconfig.php');   
        $phrase = $_POST["question"];
        $servedQuestions = array();
        $questions = array(); // Variable pour stocker les questions récupérées

        if(isset($phrase))
        {
            // Get random question numbers
            while(count($servedQuestions) < 10) // Correction de la condition
            {
                $nb = mt_rand(1,10); 
                if(in_array($nb, $servedQuestions)) continue;

                // Get the total number of questions
                $query = mysqli_query($db, "SELECT * FROM questions WHERE id_questions = '".$nb."'");

                if ($query) {
                    $questions[] = mysqli_fetch_assoc($query); // Ajout des résultats dans le tableau questions
                    $servedQuestions[] = $nb; // Ajouter l'ID de la question à servedQuestions
                }
            }
            return $questions; // Retourner le tableau des questions récupérées
        }
    }
}
?>