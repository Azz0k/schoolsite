import MenuData from './MenuData';
import MenuItem from './MenuItem';
class Navbar extends React.component{
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
export default Navbar;