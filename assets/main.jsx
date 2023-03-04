import { Component, h, render } from 'preact'
export default class Hello extends Component {
    constructor() {
        super()
        this.state = {
            name: 'Jean',
            count: 0,
        }
    }
    static tagName = 'hello-element';

    increment = () => {
        let incr = this.state.count + 1 
        this.setState({count: incr})
    }
    render(props, state) {
        return(<div><h1>Preact</h1>
        <h2>{state.name}</h2>
        <h3>{state.count}</h3>
        <button onClick={this.increment}>Incrément</button>
        </div>)
    }
}



