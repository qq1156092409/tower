<?php
namespace app\models\form;
use app\models\Comment;
use app\models\Discuss;
use app\models\multiple\G;
use app\models\Operation;
use app\models\UserComment;
class CommentForm extends Comment{
    const CREATE = "create";
    const DESTROY = "destroy";
    const EDIT = "edit";
    const TOGGLE_PRAISE = "togglePraise";
    public function scenarios(){
        return [
            self::CREATE=>["model","value","text"],
            self::DESTROY=>["id"],
            self::EDIT=>["id","text"],
            self::TOGGLE_PRAISE=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            [["id","model","value","text"],"required"],
            ["id","exist"],
        ];
        return array_merge($rules, parent::rules());
    }
    //--action
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        if($flag=$this->createComment()){
            $this->createOperation(Operation::COMMENT);
            $this->syncDiscuss();
        }
        return $flag;
    }

    /**
     * comment,operation,userComments
     * @param bool|true $validate
     * @return bool|int
     * @throws \Exception
     * @throws \yii\base\InvalidParamException
     */
    public function destroy($validate=true){
        if($validate && !$this->validate()) return false;
        $comment=$this->getComment();
        if($flag=$comment->delete()){
            Operation::deleteAll(["type"=>Operation::COMMENT,"withID"=>$comment->id]);
            UserComment::deleteAll(["commentID"=>$comment->id]);
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $comment=$this->getComment();
        $comment->text=$this->text;
        return $comment->save();
    }
    public function togglePraise($validate=true){
        if ($validate && !$this->validate()) return false;
        $userComment = UserComment::findOne(["commentID" => $this->id, "userID" => \Yii::$app->user->id]);
        if($userComment){
            return $userComment->delete();
        }else{
            $userComment=new UserComment([
                "commentID"=>$this->id,
                "userID"=>\Yii::$app->user->id,
            ]);
            return $userComment->save();
        }
    }
    //--sub action
    private function createComment(){
        $comment=new Comment($this->attributes);
        $comment->userID=\Yii::$app->user->id;
        $comment->loadDefaultValues();
        $comment->create=date("Y-m-d H:i:s");
        if ($flag = $comment->save()) {
            $this->setComment($comment);
        }
        return $flag?$comment:false;
    }
    private function createOperation($type){
        $comment=$this->getComment();
        $textMap=[
            Operation::COMMENT=>"回复了" . G::getContent($comment->model, "chinese"),
        ];
        $operation=new Operation([
            'userID' => \Yii::$app->user->id,
            'type' =>$type,
            'text' =>$textMap[$type],
            'value' =>$comment->value,
            'model' =>$comment->model,
            'create' => date("Y-m-d H:i:s"),
            "withID"=>$comment->id,
        ]);
        $operation->loadDefaultValues();
        return $operation->save()?$operation:false;
    }
    private function syncDiscuss(){
        $comment=$this->getComment();
//        $target=$comment->target;
        if($discuss=$comment->discuss){
            $discuss->update = date("Y-m-d H:i:s");
        }else{
            $discuss=new Discuss([
                'model' => $comment->model,
                'value' => $comment->value,
            ]);
            $discuss->loadDefaultValues();
        }
        return $discuss->save()?$discuss:false;
    }
    //--cache
    private $_comment=false;

    /**
     * @return Comment
     * @throws \yii\base\InvalidConfigException
     */
    public function getComment(){
        if($this->_comment===false){
            $this->_comment = Comment::findOne($this->id);
        }
        return $this->_comment;
    }
    public function setComment(Comment $comment){
        $this->_comment=$comment;
        return $this;
    }

}