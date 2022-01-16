<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Exercise;
use App\Ans_pattern;
use App\User;
use App\E_answer;
use App\E_setting;
use App\E_group;
use App\E_class;
use App\E_member;
use App\Facades\Csv;
use App\Http\Requests\UploadCsvFile;
use App\Http\Requests\StorePhoto;
use SplFileObject;

class E_learning2Controller extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

//  public function index()
//  {
//    $user_id = Auth::user()->id;
//    $items = E_member::where('user_id', $user_id)->select('e_groups_id')->getQuery();
//    return Exercise::whereIn('e_groups_id', $items)->get();
//  }

  public function show(Exercise $id)
  {
    return $id;
  }

  public function store(Request $request)
  {
    return Exercise::create($request->all());
  }

  public function update(Request $request, Exercise $id)
  {
    $id->update($request->all());
    return $id;
  }

  public function destroy(Exercise $id)
  {
    $id->delete();
    return $id;
  }

  public function tc_menu($e_groups_id)
  {
//    $user_id = Auth::user()->id;
//    $items = E_member::where('user_id', $user_id)->select('e_groups_id')->getQuery();
//    return Exercise::where('q_no', 0)->whereIn('e_groups_id', $items)->get();
    return Exercise::where('q_no', 0)->where('e_groups_id', $e_groups_id)->get();
  }

  public function tc_menu2($e_classes_id)
  {
    $e_groups_id = E_class::where('id', $e_classes_id)->select('e_groups_id')->getQuery();
    return Exercise::where('q_no', 0)->whereIn('e_groups_id', $e_groups_id)->get();
  }

  public function list($e_groups_id, $no)
  {
    return Exercise::where('e_groups_id', $e_groups_id)->where('no', $no)->get();
  }

  public function groups_menu()
  {
    $user_id = Auth::user()->id;
    $items1 = E_member::where('user_id', $user_id)->select('e_classes_id')->getQuery();
    $items2 = E_class::whereIn('id', $items1)->select('e_groups_id')->getQuery();
    return E_group::whereIn('id', $items2)->get();
  }

  public function classes_menu()
  {
    $user_id = Auth::user()->id;
    $items = E_member::where('user_id', $user_id)->select('e_classes_id')->getQuery();
    return E_class::whereIn('id', $items)->get();
  }

  public function class_list($e_classes_id)
  {
    return E_member::where('e_classes_id', $e_classes_id)->with('user')->get();
  }

  public function class_list_delete($id)
  {
    E_member::where('user_id', $id)->delete();
  }

  public function select_title($e_classes_id)
  {
    $selected_titles = E_setting::where('e_classes_id', $e_classes_id)->get('no');
    $setting = array();
    $i = 0;
    foreach($selected_titles as $selected_title){
      $setting[$i] = $selected_title->no;
      $i++;
    }
    return $setting;
  }

  public function setting($e_classes_id, Request $request)
  {
    $selected_titles = $request->input();
    $i = 0;
    $section_titles = Exercise::where('q_no', 0)->get();
    foreach($section_titles as $section_title){
      $item = E_setting::where('e_classes_id', $e_classes_id)->where('no', $section_title->no)->first();
      if($item == null){
        if($i < count($selected_titles)){
          if($section_title->no == $selected_titles[$i]){
            $titles = new E_setting;
            $titles->e_classes_id = $e_classes_id;
            $titles->no = $selected_titles[$i];
            $titles->save();
            $i++;
          }
        }
      }else if($section_title->no == $item->no){
        if($i < count($selected_titles)){
          if($section_title->no == $selected_titles[$i]) $i++;
        }else E_setting::where('e_classes_id', $e_classes_id)->where('no', $section_title->no)->delete();
      }
    }
    return response($request, 201);
  }

  public function st_menu($e_classes_id)
  {
    $selected_titles = E_setting::where('e_classes_id', $e_classes_id)->select('no')->getQuery();
    $e_groups_id = E_class::where('id', $e_classes_id)->select('e_groups_id')->getQuery();
    return Exercise::where('q_no', 0)->whereIn('e_groups_id', $e_groups_id)->whereIn('no', $selected_titles)->get();
  }

  public function rdm_list($e_classes_id, $no)
  {
    $e_groups_id = E_class::where('id', $e_classes_id)->select('e_groups_id')->getQuery();
    $questions = Exercise::whereIn('e_groups_id', $e_groups_id)->where('no', $no)->where('q_no', '>', '0')->get();
    foreach($questions as $question){
      $a_ptn = mt_rand(1, 24);
      $a_ptn_w = Ans_pattern::where('id', $a_ptn)->first();
      $a_ptn_list = array();
      $a_ptn_list[0] = $a_ptn_w->ans1;
      $a_ptn_list[1] = $a_ptn_w->ans2;
      $a_ptn_list[2] = $a_ptn_w->ans3;
      $a_ptn_list[3] = $a_ptn_w->ans4;
      $ans_list = array();
      $ans_list[$a_ptn_list[0] - 1] = $question->ans1;
      $ans_list[$a_ptn_list[1] - 1] = $question->ans2;
      $ans_list[$a_ptn_list[2] - 1] = $question->ans3;
      $ans_list[$a_ptn_list[3] - 1] = $question->ans4;
      $question->ans1 = $ans_list[0];
      $question->ans2 = $ans_list[1];
      $question->ans3 = $ans_list[2];
      $question->ans4 = $ans_list[3];
      $question->ans = $a_ptn_list[$question->ans - 1];
      $exp_list = array();
      $exp_list[$a_ptn_list[0] - 1] = $question->exp1;
      $exp_list[$a_ptn_list[1] - 1] = $question->exp2;
      $exp_list[$a_ptn_list[2] - 1] = $question->exp3;
      $exp_list[$a_ptn_list[3] - 1] = $question->exp4;
      $question->exp1 = $exp_list[0];
      $question->exp2 = $exp_list[1];
      $question->exp3 = $exp_list[2];
      $question->exp4 = $exp_list[3];
    }
    return $questions;
  }

  public function a_ptn($a_ptn)
  {
    return Ans_pattern::where('id', $a_ptn)->get();
  }

  public function question_import(UploadCsvFile $request)
  {
    Log::Debug(__CLASS__.':'.__FUNCTION__, $request->all());
    // 拡張子チェックがうまく動かないことがあるので独自で実施
    // -- https://api.symfony.com/3.0/Symfony/Component/HttpFoundation/File/UploadedFile.html
    $file = $request -> file('csvfile');
    if ($file ->getClientOriginalExtension() != 'csv') {
      Log::Debug(__CLASS__.':'.__FUNCTION__.' File Name: '. $file ->getClientOriginalName());
      Log::Debug(__CLASS__.':'.__FUNCTION__.' File Extension: '. $file ->getClientOriginalExtension());
      Log::Debug(__CLASS__.':'.__FUNCTION__.' ClientMimeType: '. $file ->getClientMimeType());
      Log::Debug(__CLASS__.':'.__FUNCTION__.' MimeType: '. $file ->getMimeType());
      return new JsonResponse(['errors' => [ 'csvfile' => 'CSVファイルを指定してください']], 422);
    }
    // CSV をパース
    try {
      $rows = Csv::parse($file);
    } catch (\Exception $e) {
      Log::Debug(__CLASS__.':'.__FUNCTION__.' parse Exception : '. $e -> getMessage());
      return new JsonResponse(['errors' => [
        'csvfile' => 'CSVファイルの読み込みでエラーが発生しました',
        'exception' => $e -> getMessage()
        ]]
      , 422);
    }
    // １行ずつ処理
    $ret = array();
    foreach ($rows as $line => $value) {
      // 行データに対してのバリデート（必須・内容の確認）
      //      $validator = $this->validator($value);
      // データに問題があればエラーを記録 => 処理は継続
      //            if ($validator -> fails()) {
      //                foreach ($validator -> errors() -> all() as $message) {
      //                    Log::Debug(__CLASS__.':'.__FUNCTION__.' ERROR line('.$line.') '.$message);
      //                    $ret['errors'][] = ['line' => $line, 'message' => $message];
      //                }
      //                continue;
      //            }
      Log::Debug(__CLASS__.':'.__FUNCTION__.' INSERT line('.$line.') '.$value['quest']);
      Exercise::create($value);
      //      $ret['insert'][] = ['line' => $line, 'message' => $value['name']];
    } // １行ずつ処理
    // 結果を戻す
    return response($request, 201);
    //    return ['import' => $ret];
  }

  public function upload(StorePhoto $request)
  {
    $exists = Storage::disk('public')->exists($request->photo->getClientOriginalName());
    $filename = $request->photo->getClientOriginalName();
    if($exists == true)
      Storage::disk('public')->delete($filename);
    Storage::disk('public')->putFileAs('', $request->photo, $filename);
    return response($request, 201);
  }

  public function question_import2(UploadCsvFile $request)
  {
    // CSVimport::truncate();
    setlocale(LC_ALL, 'ja_JP.UTF-8');
    $uploaded_file = $request->file('csvfile');
    $file_path = $request->file('csvfile');
    $file = new SplFileObject($file_path);
    $file->setFlags(SplFileObject::READ_CSV);
    //配列の箱を用意
    $array = [];
    $row_count = 1;
    foreach ($file as $row)
    {
      if ($row === [null]) continue; 
      if ($row_count > 1)
      {
        for($i = 0; $i < 13; $i++){
          if($row[$i] == null) $row[$i] = null;
        }
        $e_groups_id = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
        $no = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
        $q_no = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
        $quest = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');
        $ans1 = mb_convert_encoding($row[4], 'UTF-8', 'SJIS');
        $ans2 = mb_convert_encoding($row[5], 'UTF-8', 'SJIS');
        $ans3 = mb_convert_encoding($row[6], 'UTF-8', 'SJIS');
        $ans4 = mb_convert_encoding($row[7], 'UTF-8', 'SJIS');
        $ans = mb_convert_encoding($row[8], 'UTF-8', 'SJIS');
        $exp1 = mb_convert_encoding($row[9], 'UTF-8', 'SJIS');
        $exp2 = mb_convert_encoding($row[10], 'UTF-8', 'SJIS');
        $exp3 = mb_convert_encoding($row[11], 'UTF-8', 'SJIS');
        $exp4 = mb_convert_encoding($row[12], 'UTF-8', 'SJIS');
        $exp0 = mb_convert_encoding($row[13], 'UTF-8', 'SJIS');
        $csvimport_array = [
          'e_groups_id' => $e_groups_id,
          'no' => $no,
          'q_no' => $q_no,
          'quest' => $quest,
          'ans1' => $ans1,
          'ans2' => $ans2,
          'ans3' => $ans3,
          'ans4' => $ans4,
          'ans' => $ans,
          'exp1' => $exp1,
          'exp2' => $exp2,
          'exp3' => $exp3,
          'exp4' => $exp4,
          'exp0' => $exp0
        ];
        // つくった配列の箱($array)に追加
        array_push($array, $csvimport_array);
      }
      $row_count++;
    }
    //追加した配列の数を数える
    $array_count = count($array);
    //もし配列の数が500未満なら
    if ($array_count < 500){
      //配列をまるっとインポート(バルクインサート)
      Exercise::insert($array);
    } else {
      //追加した配列が500以上なら、array_chunkで500ずつ分割する
      $array_partial = array_chunk($array, 500); //配列分割
      //分割した数を数えて
      $array_partial_count = count($array_partial); //配列の数
      //分割した数の分だけインポートを繰り替えす
      for ($i = 0; $i <= $array_partial_count - 1; $i++){
        Exercise::insert($array_partial[$i]);
      }
    }
  }

  public function user_index()
  {
    return User::all();
  }

  public function user_show(User $id)
  {
    return $id;
  }

  public function user_store(Request $request)
  {
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    if($request->role > 5)
      $user->password_raw = $request->password;
    $user->role = $request->role;
    $user->save();
    return response($request, 201);
  }

  public function user_update(Request $request, User $id)
  {
    $password_raw = $request->password;
    $request->merge(['password' => Hash::make($request->password)]);
    $id->update($request->all());
    if($request->role > 5){
      $id->password_raw = $password_raw;
      $id->save();
    }
    return $id;
  }

  public function user_destroy(User $id)
  {
    $id->delete();
    return $id;
  }

  public function user_import(UploadCsvFile $request)
  {
    Log::Debug(__CLASS__.':'.__FUNCTION__, $request->all());
    // 拡張子チェックがうまく動かないことがあるので独自で実施
    // -- https://api.symfony.com/3.0/Symfony/Component/HttpFoundation/File/UploadedFile.html
    $file = $request -> file('csvfile');
    if ($file ->getClientOriginalExtension() != 'csv') {
      Log::Debug(__CLASS__.':'.__FUNCTION__.' File Name: '. $file ->getClientOriginalName());
      Log::Debug(__CLASS__.':'.__FUNCTION__.' File Extension: '. $file ->getClientOriginalExtension());
      Log::Debug(__CLASS__.':'.__FUNCTION__.' ClientMimeType: '. $file ->getClientMimeType());
      Log::Debug(__CLASS__.':'.__FUNCTION__.' MimeType: '. $file ->getMimeType());
      return new JsonResponse(['errors' => [ 'csvfile' => 'CSVファイルを指定してください']], 422);
    }
    // CSV をパース
    try {
      $rows = Csv::parse($file);
    } catch (\Exception $e) {
      Log::Debug(__CLASS__.':'.__FUNCTION__.' parse Exception : '. $e -> getMessage());
      return new JsonResponse(['errors' => [
        'csvfile' => 'CSVファイルの読み込みでエラーが発生しました',
        'exception' => $e -> getMessage()
        ]]
      , 422);
    }
    // １行ずつ処理
    $ret = array();
    foreach ($rows as $line => $value) {
      // 行データに対してのバリデート（必須・内容の確認）
      //            $validator = $this->validator($value);
      // データに問題があればエラーを記録 => 処理は継続
      //            if ($validator -> fails()) {
      //                foreach ($validator -> errors() -> all() as $message) {
      //                    Log::Debug(__CLASS__.':'.__FUNCTION__.' ERROR line('.$line.') '.$message);
      //                    $ret['errors'][] = ['line' => $line, 'message' => $message];
      //                }
      //                continue;
      //            }
      Log::Debug(__CLASS__.':'.__FUNCTION__.' INSERT line('.$line.') '.$value['name']);
      $user = new User;
      $user->name = $value['name'];
      $user->email = $value['email'];
      $user->password = Hash::make($value['password']);
      if($value['role'] > 5)
        $user->password_raw = $value['password'];
      $user->role = $value['role'];
      $user->save();
      //      $ret['insert'][] = ['line' => $line, 'message' => $value['name']];
    } // １行ずつ処理
    // 結果を戻す
    return response($request, 201);
    //    return ['import' => $ret];
  }

  public function user_import2(UploadCsvFile $request)
  {
    // CSVimport::truncate();
    setlocale(LC_ALL, 'ja_JP.UTF-8');
    $uploaded_file = $request->file('csvfile');
    $file_path = $request->file('csvfile');
    $file = new SplFileObject($file_path);
    $file->setFlags(SplFileObject::READ_CSV);
    //配列の箱を用意
    $array = [];
    $row_count = 1;
    foreach ($file as $row)
    {
      if ($row === [null]) continue; 
      if ($row_count > 1)
      {
        for($i = 0; $i < 4; $i++){
          if($row[$i] == null) $row[$i] = null;
        }
        $name = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
        $email = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
        $password = Hash::make(mb_convert_encoding($row[2], 'UTF-8', 'SJIS'));
        $role = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');
        if($role > 5) $password_raw = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
        else $password_raw = null;
        $csvimport_array = [
          'name' => $name,
          'email' => $email,
          'password' => $password,
          'password_raw' => $password_raw,
          'role' => $role,
        ];
        // つくった配列の箱($array)に追加
        array_push($array, $csvimport_array);
      }
      $row_count++;
    }
    // 追加した配列の数を数える
    $array_count = count($array);
    // もし配列の数が500未満なら
    if ($array_count < 500){
      // 配列をまるっとインポート(バルクインサート)
      User::insert($array);
    } else {
      // 追加した配列が500以上なら、array_chunkで500ずつ分割する
      $array_partial = array_chunk($array, 500); //配列分割
      // 分割した数を数えて
      $array_partial_count = count($array_partial); //配列の数
      // 分割した数の分だけインポートを繰り替えす
      for ($i = 0; $i <= $array_partial_count - 1; $i++){
        User::insert($array_partial[$i]);
      }
    }
    return response($request, 201);
  }

  public function answer_record(Request $request)
  {
    $e_answer = new E_answer;
    $e_answer->user_id = Auth::user()->id;
    $e_answer->e_classes_id = $request->e_classes_id;
    $e_answer->s_id = $request->s_id;
    $e_answer->no = $request->no;
    $e_answer->q_no = $request->q_no;
    $e_answer->correct = $request->correct;
    $e_answer->save();
    return  response($request, 201);
  }

  public function answer_list($no)
  {
    $answers = E_answer::where('no', $no)->orderBy('s_id', 'asc')->orderBy('user_id', 'asc')->orderBy('q_no', 'asc')->with('user')->get();
    $answer_lists = array(array());
    $i = -1;
    $tmp_s_id = 0;
    $tmp_user_id = 0;
    foreach($answers as $answer){
      if($tmp_s_id != $answer->s_id || $tmp_user_id != $answer->user_id){
        $i++;
        $tmp_s_id = $answer->s_id;
        $tmp_user_id = $answer->user_id;
        $answer_lists[$i][0] = $answer->s_id;
        $answer_lists[$i][1] = $answer->user->name;
        $answer_lists[$i][2] = $answer->user->email;
        $answer_lists[$i][3] = $answer->created_at->format('Y年m月d日 H時i分s秒');
        $j = 4;
      }
      $answer_lists[$i][$j] = $answer->correct;
      $j++;
    }
    return $answer_lists;
  }

  public function answer_list2($id, $e_classes_id)
  {
    $answers = E_answer::where('user_id', $id)->where('e_classes_id', $e_classes_id)->orderBy('no', 'asc')->orderBy('s_id', 'desc')->orderBy('q_no', 'asc')->get();
    $answer_lists = array(array());
    $i = -1;
    $tmp_s_id = 0;
    foreach($answers as $answer){
      if($tmp_s_id != $answer->s_id){
        $i++;
        $tmp_s_id = $answer->s_id;
        $answer_lists[$i][0] = $answer->s_id;
        $sections = Exercise::where('no', $answer->no)->where('q_no', 0)->first();
        $answer_lists[$i][1] = $sections->quest;
        $answer_lists[$i][2] = $answer->created_at->format('Y年m月d日 H時i分s秒');
        $j = 3;
      }
      $answer_lists[$i][$j] = $answer->correct;
      $j++;
    }
    return $answer_lists;
  }

  public function answer_delete($id)
  {
    E_answer::where('user_id', $id)->delete();
  }

}