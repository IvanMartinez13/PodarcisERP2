import React from "react";
import ReactDOM  from "react-dom";
import axios from "axios";
import RowEvaluation from "./components/RowEvaluation";
import StrategyEvolution from "./components/StrategyEvolution";

class Evaluation extends React.Component{

    constructor(props){

        super(props);

        this.state = {
            loading: true,
            save: false,
            saved: false,
            rows: [],
        };

        this.yearToday = new Date().getFullYear();
        this.years = [];

        this.strategy = this.props.strategy;
        this.objective = this.props.objective;

        this.observations = this.strategy.observations;

        this.update = this.props.update;
        this.del = this.props.del;


        
    
        this.updateRows = this.updateRows.bind(this);


    }

    render(){

        {/* LOADING */}
        if (this.state.loading) {
            return(
                <div className="row">
                    <div className="col-lg-9">
                        <div className="ibox">
                            <div className="ibox-title">
                                <h5>{this.strategy.title}</h5>

                                <div className="ibox-tools">
                                    <a className="collapse-link" href="">
                                        <i className="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div className="ibox-content">

                                <div className="spiner-example">   
                                    <div className="sk-spinner sk-spinner-double-bounce">
                                        <div className="sk-double-bounce1"></div>
                                        <div className="sk-double-bounce2"></div>
                                    </div>
                                </div>

                                <p className="text-center">Cargando...</p>

                            </div>
                            <div className="ibox-footer">
                                Podarcis SL. &copy; {this.yearToday} 
                            </div>

                        </div>
                    </div>

                    <div className="col-lg-3 d-none d-lg-block">
                        <h4> {this.objective.title} </h4>
                        <p dangerouslySetInnerHTML={{ __html: this.objective.description }}></p>

                        <small><strong>Año base:</strong> {this.objective.base_year}</small> <br></br>
                        <small><strong>Indicador:</strong> {this.objective.indicator}</small> <br></br>
                        <small><strong>Encargado:</strong> {this.objective.manager}</small> <br></br>
                        <small><strong>Recursos</strong></small>
                        <small>
                            <p dangerouslySetInnerHTML={{ __html: this.objective.resources }}></p>
                        </small>
                        

                    </div>
                </div>


                );
        }

        {/* EVALUATION TABLE */}
        return(
            <div className="row">
                <div className="col-lg-9">
                    <div className="ibox">
                        <div className="ibox-title">
                            <h5>{this.strategy.title}</h5>

                            <div className="ibox-tools">
                                <a role={'button'} className="collapse-link">
                                    <i className="fa fa-chevron-up" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div className="ibox-content">

                            {/* DESCRIPCIÓN */}
                            <div className="row mb-3">
                                <div className="col-lg-8">
                                    <div className="row">
                                        <div className="col-lg-12">
                                            <h5>Descripción</h5>
                                            <p dangerouslySetInnerHTML={{ __html: this.strategy.description }}></p>
                                        </div>


                                        <div className="col-lg-6">
                                            <h5>Actuaciones</h5>
                                            <p dangerouslySetInnerHTML={{ __html: this.strategy.performances }}></p>
                                        </div>

                                        <div className="col-lg-6">
                                            <h5>Recursos</h5>
                                            <p dangerouslySetInnerHTML={{ __html: this.strategy.resources }}></p>
                                        </div>

                                        
                                        <div className="col-lg-4">
                                            <h5>Encargado</h5>
                                            <p>{this.strategy.manager}</p>
                                        </div>

                                        <div className="col-lg-4">
                                            <h5>Año base</h5>
                                            <p>{this.strategy.base_year}</p>
                                        </div>

                                        
                                        <div className="col-lg-4">
                                            <h5>Año objetivo</h5>
                                            <p>{this.strategy.target_year}</p>
                                        </div>


                                        <div className="col-lg-4">
                                            <h5>Indicador</h5>
                                            <p>{this.strategy.indicator}</p>
                                        </div>

                                        <div className="col-lg-4">

                                            <h5>
                                                {
                                                    (this.strategy.increase == 1)?

                                                    'Incremento Objetivo(%)'

                                                    :

                                                    'Reducción Objetivo(%)'
                                                }

                                            </h5>
                                            
                                            <p>{ this.formatValue( Number(this.strategy.target).toFixed(3) )} %</p>
                                        </div>

                                        <div className="col-lg-4">
                                            <h5>Valor objetivo</h5>
                                            <span id={"strategy_target_value"+this.strategy.token}></span>
                                        </div>

                                        <div className="col-lg-12">
                                            <h5>
                                                <label htmlFor="observations">Observaciones:</label>                      
                                            </h5>

                                            <textarea defaultValue={this.observations} id="observations" className="form-control"></textarea>

                                            {
                                                (this.update == 1)?
                                                    <div className="text-right">
                                                        <button className="btn btn-primary mt-2 " onClick={() => {
                                                            this.oservations();
                                                        }}>Guardar observaciones</button>
                                                    </div>
                                                :
                                                    <div className="alert alert-warning">
                                                        No tienes permisos para cambiar las observaciones
                                                    </div>
                                            }
                                        </div>





                                    </div>
                                    
                                    

                                    
                                </div>

                                <div className="col-lg-4 text-center">
                                    <h5>Variación {this.strategy.indicator}</h5>
                                    <StrategyEvolution strategy={this.strategy}></StrategyEvolution>
                                </div>
                            </div>

                           

                            {/* BOTONES */}

                            {
                                (this.update == 1) ?  
                                
                                <div className="row mb-3">
                                    <div className="col-6 text-left">
                                        <button className="btn btn-primary" onClick={ () => {
                                            this.newRow()
                                        } }>
                                            Nueva fila...
                                        </button>
                                    </div>
                                    <div className="col-6 text-right">
                                        <button className="btn btn-primary" onClick={ () => {
                                            this.save();
                                        } }>
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                                :  
                                <div className="alert alert-warning">No tienes permisos para modificar esta tabla</div>
                            }
                           

                            {/* TABLA */}
                            <div className="table-responsive mb-3">
                                <table className="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Archivo</th>
                                            <th>Año seleccionado</th>
                                            <th>Valor observado</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                        {   this.state.rows.map( (row, index) => {

                                                return(
                                                    
                                                    <RowEvaluation
                                                        key={row.id}
                                                        id={row.id}
                                                        year={row.year}
                                                        value={row.value}
                                                        years={this.years}
                                                        updateRows={this.updateRows}
                                                        files={row.files}
                                                        update={this.update}
                                                        del={this.del}
                                                    ></RowEvaluation>
                                                );
                                            } )
                                        }
                                        
                                    </tbody>
                                </table>
                            </div>

                            {/* BOTONES */}
                            {
                                (this.update == 1) ?  
                                
                                <div className="row mb-3">
                                    <div className="col-6 text-left">
                                        <button className="btn btn-primary" onClick={ () => {
                                            this.newRow()
                                        } }>
                                            Nueva fila...
                                        </button>
                                    </div>
                                    <div className="col-6 text-right">
                                        <button className="btn btn-primary" onClick={ () => {
                                            this.save();
                                        } }>
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                                :  
                                <div className="alert alert-warning">No tienes permisos para modificar esta tabla</div>
                            }

                        </div>
                        <div className="ibox-footer">
                            Podarcis SL. &copy; {this.yearToday}
                        </div>
                    </div>
                </div>

                <div className="col-lg-3 d-none d-lg-block">
                    <h4> {this.objective.title} </h4>

                    <p dangerouslySetInnerHTML={{ __html: this.objective.description }}></p>

                    <small><strong>Año base:</strong> {this.objective.base_year}</small> <br></br>
                    <small><strong>Indicador:</strong> {this.objective.indicator}</small> <br></br>
                    <small><strong>Encargado:</strong> {this.objective.manager}</small> <br></br>
                     <small><strong>Recursos:</strong></small>
                    <small>
                        <p dangerouslySetInnerHTML={{ __html: this.objective.resources }}></p>
                    </small>
                </div>
            </div>

        );
    }

    //ON MOUNT
    componentDidMount()
    {
        axios.post('/ods/evaluate/get_evaluations', {token: this.strategy.token}).then( (response) => {

            //GET YEARS
            for (let index = this.objective.base_year; index <= this.objective.target_year; index++) {
                this.years.push(index);
            }

            //PUSH ROWS
            let rows = this.state.rows;

            let evaluations = response.data.evaluations;


            if (evaluations != null) {
                
                //EVALUATIONS NOT NULL
                evaluations.map( (evaluation, index) => {

                    let item = {
                        index: rows.length,
                        id: evaluation.token,
                        year: evaluation.year,
                        value: evaluation.value,
                        files: evaluation.files,
                        delete: false,
                    }

                    rows.push(item); //PUSH ITEM
                } );
            }else{

                //EVALUATIONS IS NULL
                let item = {
                    index: 0,
                    id: 'row_0',
                    year: '',
                    value: '',
                    files: [],
                    delete: false,
        
                }

                rows.push(item); //PUSH EMPTY ITEM
            }
            
            this.setState({loading:false, rows: rows, save: false});
        }).then( () => {
            $('#observations').summernote({
                placeholder: "Observaciones...",
                height: '200px'
            })
            const handleObservations = (val) => { this.observations = val }
                    
            $('#observations').on('summernote.change', function(e){
                handleObservations(e.target.value)
            })
        } );
    }

    componentDidUpdate()
    {
        if (this.state.save == true && this.state.saved == true) {
            axios.post('/ods/evaluate/get_evaluations', {token: this.strategy.token}).then( (response) => {
                this.years = [];
                //GET YEARS
                for (let index = this.objective.base_year; index <= this.objective.target_year; index++) {
                    this.years.push(index);
                }
    
                //PUSH ROWS
                let rows = [];
    
                let evaluations = response.data.evaluations;
    
    
                if (evaluations != null) {
                    
                    //EVALUATIONS NOT NULL
                    evaluations.map( (evaluation, index) => {
    
                        let item = {
                            index: rows.length,
                            id: evaluation.token,
                            year: evaluation.year,
                            value: evaluation.value,
                            files: evaluation.files,
                            delete: false,
                        }
    
                        rows.push(item); //PUSH ITEM
                    } );
                }else{
    
                    //EVALUATIONS IS NULL
                    let item = {
                        index: 0,
                        id: 'row_0',
                        year: '',
                        value: '',
                        files: [],
                        delete: false,
            
                    }
    
                    rows.push(item); //PUSH EMPTY ITEM
                }
                
                
                this.setState({loading:false, rows: rows, save: false, saved: false});

            }).then( () => {

                $('#observations').summernote({
                    placeholder: "Observaciones...",
                    height: '200px'
                })
                const handleObservations = (val) => { this.observations = val }
                        
                $('#observations').on('summernote.change', function(e){
                    handleObservations(e.target.value)
                })

            } );;
        }

    }
    
    //METHODS
    newRow(){

        var rows = this.state.rows;

        let item = {
            index: rows.length,
            id: 'row_'+rows.length,
            year: '',
            value: '',
            files: [],
            delete: false,

        }

        rows.unshift(item);//PUSH TO TOP

        this.setState({
            loading: false,
            rows: rows,
        });


        
    }

    updateRows(data){
        
        let id = data.id;
        let rows = this.state.rows;
        
        rows.map( (row, index) => {
            if (id == row.id) {
                rows[index] = data;
            }
        } );

        this.setState({
            loading: false,
            rows: rows,
        });
    }

    save(){

        let rows = this.state.rows;
        let token = this.strategy.token;
        
        this.setState({loading: true, save: true});

        axios.post('/ods/evaluate/save', {data: rows, token: token}).then( (response) => {
            let data = response.data;

            if (data.status == "success") {
                
                toastr.success(data.message);
                this.setState({saved: true}); //NOW CAN UPDATE ALL

            }else{
                toastr.error(data.message);
                this.setState({saved: true}); //NOW CAN UPDATE ALL
            }

        } );
    }

    oservations(){
        let value = $("#observations").val();
        $('#observations').summernote('destroy');
        this.setState({loading: true, save: true});
        axios.post('/ods/strategy/observation', {observations: value, token: this.strategy.token}).then( (response) => {
            if (response.data.status == 'success') {
                
                toastr.success( response.data.message )
            
                this.setState({saved: true});
            }else{
                
                toastr.error( response.data.message )

                this.setState({saved: true});
            }
        })
    }

    formatValue(number){
        let value = number
        value = value.replace('.', ',');
        return value;
        
    }
}

export default Evaluation;

if (document.getElementsByTagName('evaluation').length >=1) {
    
    let component = document.getElementsByTagName('evaluation')[0];
    let strategy = JSON.parse(component.getAttribute('strategy'));
    let objective = JSON.parse(component.getAttribute('objective'));
    let update = component.getAttribute('update');
    let del = component.getAttribute('delete');
    

    ReactDOM.render(<Evaluation strategy={strategy} objective={objective} update={update} del={del} />, component);
}