export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.type === 'admin';
    }

    isEditor(){
        return this.user.type === 'editor';
    }

    isUser(){
        return this.user.type === 'user';
    }
    
    isAdminOrUser(){
        if(this.user.type === 'user' || this.user.type === 'admin' || this.user.type === 'editor'){
            return true;
        }
    }
}

