<?php

namespace App\Imports;

use App\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionsImport implements ToCollection {

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows) {

        json_encode($rows);
        foreach ($rows as $key => $row) {

            if ($key > 0) {

                if ($key == 1) {
                    $checklist = \App\Checklist::create([
                                'name' => $row[0],
                                'description' => 'description',
                    ]);
                }



                if ($row[1] == "Type 1") {
                    $question_subcategory = \App\QuestionSubcategory::where('question_category_id', '=', 1)->where('name', '=', $row[2])->where('checklist_id', '=', $checklist->id)->first();
                    if ($question_subcategory) {
                        
                    } else {
                        $question_subcategory = \App\QuestionSubcategory::create([
                                    'name' => $row[2],
                                    'checklist_id' => $checklist->id,
                                    'description' => 'description',
                                    'question_category_id' => 1,
                        ]);
                    }
                } else {
                    $question_subcategory = \App\QuestionSubcategory::where('question_category_id', '=', 2)->where('name', '=', $row[2])->where('checklist_id', '=', $checklist->id)->first();
                    if ($question_subcategory) {
                        
                    } else {
                        $question_subcategory = \App\QuestionSubcategory::create([
                                    'name' => $row[2],
                                    'checklist_id' => $checklist->id,
                                    'description' => 'description',
                                    'question_category_id' => 2,
                        ]);
                    }
                }

                $bracket_st_1 = "";
                $question1 = "";
                $option1 = "";
                $bracket_en_1 = "";
                $operator_1 = "";

                $bracket_st_2 = "";
                $question2 = "";
                $option2 = "";
                $bracket_en_2 = "";
                $operator_2 = "";

                $bracket_st_3 = "";
                $question3 = "";
                $option3 = "";
                $bracket_en_3 = "";
                $operator_3 = "";

                $bracket_st_4 = "";
                $question4 = "";
                $option4 = "";
                $bracket_en_4 = "";
                $operator_4 = "";

                $bracket_st_5 = "";
                $question5 = "";
                $option5 = "";
                $bracket_en_5 = "";
                $operator_5 = "";

                $bracket_st_6 = "";
                $question6 = "";
                $option6 = "";
                $bracket_en_6 = "";
                $operator_6 = "";

                $bracket_st_7 = "";
                $question7 = "";
                $option7 = "";
                $bracket_en_7 = "";
                $operator_7 = "";


                $bracket_st_8 = "";
                $question8 = "";
                $option8 = "";
                $bracket_en_8 = "";
                $operator_8 = "";


                $bracket_st_9 = "";
                $question9 = "";
                $option9 = "";
                $bracket_en_9 = "";
                $operator_9 = "";


                $bracket_st_10 = "";
                $question10 = "";
                $option10 = "";
                $bracket_en_10 = "";

                if ($row[12]) {
                    $bracket_st_1 = $row[12] . " ";
                }
                if ($row[13]) {
                    $question1 = "_" . $row[13] . "_";
                }
                if ($row[14]) {
                    $option1 = " " . $row[14] . " ";
                }
                if ($row[15]) {
                    $bracket_en_1 = " " . $row[15] . " ";
                }
                if ($row[16]) {
                    $operator_1 = " " . $row[16] . " ";
                }




                if ($row[17]) {
                    $bracket_st_2 = " " . $row[17] . " ";
                }
                if ($row[18]) {
                    $question2 = "_" . $row[18] . "_";
                }
                if ($row[19]) {
                    $option2 = " " . $row[19] . " ";
                }
                if ($row[20]) {
                    $bracket_en_2 = " " . $row[20] . " ";
                }
                if ($row[21]) {
                    $operator_2 = " " . $row[21] . " ";
                }



                if ($row[22]) {
                    $bracket_st_3 = " " . $row[22] . " ";
                }
                if ($row[23]) {
                    $question3 = "_" . $row[23] . "_";
                }
                if ($row[24]) {
                    $option3 = " " . $row[24] . " ";
                }
                if ($row[25]) {
                    $bracket_en_3 = " " . $row[25] . " ";
                }
                if ($row[26]) {
                    $operator_3 = " " . $row[26] . " ";
                }



                if ($row[27]) {
                    $bracket_st_4 = " " . $row[27] . " ";
                }
                if ($row[28]) {
                    $question4 = "_" . $row[28] . "_";
                }
                if ($row[29]) {
                    $option4 = " " . $row[29] . " ";
                }
                if ($row[30]) {
                    $bracket_en_4 = " " . $row[30] . " ";
                }
                if ($row[31]) {
                    $operator_4 = " " . $row[31] . " ";
                }


                if ($row[32]) {
                    $bracket_st_5 = " " . $row[32] . " ";
                }
                if ($row[33]) {
                    $question5 = "_" . $row[33] . "_";
                }
                if ($row[34]) {
                    $option5 = " " . $row[34] . " ";
                }
                if ($row[35]) {
                    $bracket_en_5 = " " . $row[35] . " ";
                }
                if ($row[36]) {
                    $operator_5 = " " . $row[36] . " ";
                }



                if ($row[37]) {
                    $bracket_st_6 = " " . $row[37] . " ";
                }
                if ($row[38]) {
                    $question6 = "_" . $row[38] . "_";
                }
                if ($row[39]) {
                    $option6 = " " . $row[39] . " ";
                }
                if ($row[40]) {
                    $bracket_en_6 = " " . $row[40] . " ";
                }
                if ($row[41]) {
                    $operator_6 = " " . $row[41] . " ";
                }


                if ($row[42]) {
                    $bracket_st_7 = " " . $row[42] . " ";
                }
                if ($row[43]) {
                    $question7 = "_" . $row[43] . "_";
                }
                if ($row[44]) {
                    $option7 = " " . $row[44] . " ";
                }
                if ($row[45]) {
                    $bracket_en_7 = " " . $row[45] . " ";
                }
                if ($row[46]) {
                    $operator_7 = " " . $row[46] . " ";
                }




                if ($row[47]) {
                    $bracket_st_8 = " " . $row[47] . " ";
                }
                if ($row[48]) {
                    $question8 = "_" . $row[48] . "_";
                }
                if ($row[49]) {
                    $option8 = " " . $row[49] . " ";
                }
                if ($row[50]) {
                    $bracket_en_8 = " " . $row[50] . " ";
                }
                if ($row[51]) {
                    $operator_8 = " " . $row[51] . " ";
                }




                if ($row[52]) {
                    $bracket_st_9 = " " . $row[52] . " ";
                }
                if ($row[53]) {
                    $question9 = "_" . $row[53] . "_";
                }
                if ($row[54]) {
                    $option9 = " " . $row[54] . " ";
                }
                if ($row[55]) {
                    $bracket_en_9 = " " . $row[55] . " ";
                }
                if ($row[56]) {
                    $operator_9 = " " . $row[56] . " ";
                }



                if ($row[57]) {
                    $bracket_st_10 = " " . $row[57] . " ";
                }
                if ($row[58]) {
                    $question10 = "_" . $row[58] . "_";
                }
                if ($row[59]) {
                    $option10 = " " . $row[59] . " ";
                }
                if ($row[60]) {
                    $bracket_en_10 = " " . $row[60] . " ";
                }


                $parent = $bracket_st_1 . $question1 . $option1 . $bracket_en_1 . $operator_1 .
                        $bracket_st_2 . $question2 . $option2 . $bracket_en_2 . $operator_2 .
                        $bracket_st_3 . $question3 . $option3 . $bracket_en_3 . $operator_3 .
                        $bracket_st_4 . $question4 . $option4 . $bracket_en_4 . $operator_4 .
                        $bracket_st_5 . $question5 . $option5 . $bracket_en_5 . $operator_5 .
                        $bracket_st_6 . $question6 . $option6 . $bracket_en_6 . $operator_6 .
                        $bracket_st_7 . $question7 . $option7 . $bracket_en_7 . $operator_7 .
                        $bracket_st_8 . $question8 . $option8 . $bracket_en_8 . $operator_8 .
                        $bracket_st_9 . $question9 . $option9 . $bracket_en_9 . $operator_9 .
                        $bracket_st_10 . $question10 . $option10 . $bracket_en_10;



                $question = \App\Question::create([
                            'question_category_id' => $question_subcategory->question_category_id,
                            'question_subcategory_id' => $question_subcategory->id,
                            'checklist_qn' => $row[3],
                            'question_type' => 'primary',
                            'question' => $row[4],
                            'primary_question_id' => 2,
                            'primary_question_option' => 3,
                            'reference' => $row[10],
                            'help_and_guidance' => $row[11],
                            'answer_type' => 'select_option',
                            'parent' => $parent,
                            'checklist_id' => $checklist->id,
                ]);



                $options = explode(';', $row[9]);
                foreach ($options as $option) {
                    $question_option = \App\QuestionOption::create([
                                'question_id' => $question->id,
                                'option' => $option,
                                'status' => 'Activate'
                    ]);

                    if ($row[13]) {
                        $question->question_type = 'chain';
                    } else {
                        $question->question_type = 'primary';
                    }
                    $question->save();
                }

                /**
                  return new Question([
                  'question_subcategory_id'=> $row[0],
                  'question_type'    => $row[1],
                  'answer_type' => $row[2],
                  'primary_question_id'     => $row[0],
                  'primary_question_option'    => $row[1],
                  'password' => $row[2],
                  ]);
                 */
            }
        }
    }

}
