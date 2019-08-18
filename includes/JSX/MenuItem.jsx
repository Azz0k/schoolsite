
class MenuItem extends React.component{
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
export default MenuItem;