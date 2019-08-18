const MenuData = [
    {
        id:1,
        name:'Настройки',
        sub:false,
        children:[
        ]
    },
    {
        id:2,
        name:'Пользователи',
        sub:false,
        children:[
        ]
    },
    {
        id:3,
        name:'Меню',
        sub:false,
        children:[
            {
                id:4,
                name:'Горизонтальное меню',
                sub:true,
                children:[
                ]
            },
            {
                id:5,
                name:'Вертикальное меню',
                sub:true,
                children:[
                ]
            }
        ]
    },
    {
        id:4,
        name:'Материалы',
        sub:false,
        children:[
        ]
    }


];

class MenuItem extends React.Component{
    constructor(props){
        super();
        this.state = {
            id:'menu'+props.id,
            text:props.text,
            sub:props.sub,
            childs:props.childs
        }
    }
    render(){
        if (!this.state.sub && this.state.childs===0){
            return (<React.Fragment>
                <a className="nav-link active" id={this.state.id} href="#">{this.state.text}</a>
            </React.Fragment>)
        }
        if (!this.state.sub){
            return (<React.Fragment>
                <a className="nav-link dropdown-toggle" id={this.state.id} data-toggle="dropdown" href="#">{this.state.text}</a>
            </React.Fragment>);
        }
        return (<React.Fragment>
            <a className="dropdown-item" id={this.state.id} data-toggle="dropdown" href="#">{this.state.text}</a>
        </React.Fragment>);

    }
}
class Navbar extends React.Component{
    constructor(){
        super();
        this.state = {
            menu:MenuData
        }
    }
    MenuMap(data){
        if (data.children.length===0){
            return (
                <React.Fragment>
                    <li className={nav-item}>
                        <MenuItem key={data.id} id={data.id} text={data.text} childs={data.children.length} sub={data.sub}/>
                    </li>
                </React.Fragment>
            );
        }
        else{
            let temp = data.children.map(this.MenuMap);
            return (
                <React.Fragment>
                    <li className="nav-item dropdown">
                        <MenuItem key={data.id} id={data.id} text={data.text} childs={data.children.length} sub={data.sub}/>
                        <div className="dropdown-menu">
                            {temp}
                        </div>
                    </li>
                </React.Fragment>
            );
        }
    }
    render(){
        const items = this.state.menu.map(this.MenuMap);
        return(
            <nav className="navbar navbar-expand-lg navbar-light bg-light">
                <div className="container">
                    <div className="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul className="nav nav-tabs">
                            {MenuItems}
                        </ul>
                    </div>
                </div>
            </nav>

        );
    }
}