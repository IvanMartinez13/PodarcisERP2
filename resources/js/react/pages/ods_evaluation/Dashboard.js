import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";
import EvolutionObjective from "./components/EvolutionObjective";
import IndicatorVariation from "./components/IndicatorVariation";
import StrategyEvolution from "./components/StrategyEvolution";

class DashboardOds extends React.Component{

    constructor(props){
        super(props);

        this.state = {
            loading: true,
            update: false,
        
        }

        this.objectives = [];
        this.objective = '';
        this.indicator = '';
        this.title = '';
        this.strategies = [];

    }

    render(){
        if (this.state.loading) {
            return(
                <div className="animated fadeInRight">
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>
                    <p className="mt-3 text-center"> Cargando... </p>
                </div>


            );
        }
        return(

            <div className=" mb-5">
                <div className="row animated fadeInRight">

                    <div className="col-lg-5">
                        <label htmlFor="objective_selector">
                            Selecciona un objetivo:
                        </label>

                        <select id="objective_selector" defaultValue={this.objective.token}>
                            {
                                this.objectives.map( (objective, index) => {
                                    return(
                                        <option key={objective.token+index} value={objective.token}>{objective.title}</option>
                                    );
                                } )
                            }
                        </select>
                    </div>

                </div>


                <div className="row animated fadeInRight mt-4">

                    <div className="col-lg-5 mb-lg-0 mb-5 order-0">

                        <div className="glassCard text-dark" style={{height: '100%'}}>
                            <h5 className="mb-3 text-center">
                                {this.objective.title} 
                            </h5>
                    
                            <div className="row">
                                <div className="col-lg-12">
                                    <h5>
                                        Descripción
                                    </h5>

                                    <p dangerouslySetInnerHTML={ { __html: this.objective.description } }>

                                    </p>


                                </div>

                                <div className="col-lg-4">
                                    <h5>
                                        Indicador
                                    </h5>

                                    <p dangerouslySetInnerHTML={ { __html: this.objective.indicator } }>

                                    </p>
                                </div>


                                <div className="col-lg-4">

                                    <h5>Año de referencia</h5>

                                    { this.objective.base_year }


                                </div>

                                <div className="col-lg-4">
                                    <h5>Año objetivo</h5>

                                    { this.objective.target_year } 
                                </div>

                                <div className="col-lg-4">


                                    {

                                        (this.objective.increase == 0)?
                                            
                                            <h5>Reducción Objetivo(%)</h5>
                                        
                                        :
                                            <h5>Incremento Objetivo(%)</h5>

                                    }

                                    { this.objective.target } %


                                    
                                </div>

                                <div className="col-lg-4">
                                    <h5>Valor objetivo</h5>
                                    <span id="target_value"></span>
                                </div>

                                <div className="col-lg-4">
                                    <h5>
                                        Encargado
                                    </h5>

                                    {this.objective.manager}
                                </div>

                                <div className="col-lg-12">
                                    <h5>
                                        Recursos
                                    </h5>

                                    <p dangerouslySetInnerHTML={ { __html: this.objective.resources } }>

                                    </p>
                                </div>
                            </div>
                        
                            <hr></hr>
                            
                            <h3>VARIACIÓN de {this.objective.indicator}</h3>
                            <div className="mx-lg-5">
                                <IndicatorVariation objective={this.objective}></IndicatorVariation>
                            </div>
                            
                            <hr className="d-lg-none d-block"></hr>
                        </div>

                    </div>

                    <div className="col-lg-7 mb-lg-0 mb-5 order-1">
                        
                        <div className="glassCard text-dark" style={{height: '100%'}}>
                            <h5 className="mb-3 text-center">
                                Estrategias
                            </h5>

                            <div className="row">
                                {
                                    this.strategies.map( (strategy, index) => {


                                        return(
                                            <div  key={strategy.token + index} className="col-lg-6 text-center">
                                                <h5>{strategy.title}</h5>

                                                <StrategyEvolution
                                                    strategy={strategy}
                                                    
                                                ></StrategyEvolution>

                                            </div>
                                        );
                                    } )
                                }
                            </div>
                        </div>



                    </div>


                    




                </div>

            </div>


            
        );

    }

    componentDidMount(){
        axios.post('/ods/dashboard').then( (response) => {

            this.objectives = response.data.objectives;

            this.objective = response.data.objective;

            this.strategies = response.data.strategies;
            //CHANGE STATE
            this.setState({
                loading: false
            });

        } ).then( () => {

            $('#objective_selector').select2(
                {
                    placeholder: "Selecciona un objetivo",
                    theme: "bootstrap4",
                    width: "100%"
                }
            );

            const handleChangeObjective = (value) => {
                this.changeObjective(value);
            }

            //ON CHANGE
            
            $('#objective_selector').on('change', function(e){
                
                let value = e.target.value;
               
                console.log(value)
                handleChangeObjective(
                    value
                );

                
            });
        } );
    }

    componentDidUpdate(){
        if (this.state.update == true) {

            axios.post('/ods/dashboard', {token: this.objective.token}).then( (response) => {

                this.objectives = response.data.objectives;

                this.strategies = response.data.strategies;
    
                //CHANGE STATE
                this.setState({
                    loading: false,
                    update:false
                });

            } ).then( () => {
    
                $('#objective_selector').select2(
                    {
                        placeholder: "Selecciona un objetivo",
                        theme: "bootstrap4",
                        width: "100%"
                    }
                );
    
                const handleChangeObjective = (value) => {
                    this.changeObjective(value);
                }
    
                //ON CHANGE
                
                $('#objective_selector').on('change', function(e){
                
                    let value = e.target.value;
                   
                    console.log(value)
                    handleChangeObjective(
                        value
                    );
    
                    
                });
            } );
            
        }

    }

    changeObjective(value)
    {

        this.objectives.map( (obj, key) => {
            if (obj.token == value) {
                
                this.objective = obj;
            }

        } );


        

        this.setState({
            loading: true,
            update: true,
        })
        
    }
}

export default DashboardOds;

if (document.getElementsByTagName('dashboard-ods').length >=1) {
    
    let component = document.getElementsByTagName('dashboard-ods')[0];

    ReactDOM.render(<DashboardOds />, component);
}