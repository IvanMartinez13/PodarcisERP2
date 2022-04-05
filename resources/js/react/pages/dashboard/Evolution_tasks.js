import React from "react";
import ReactDOM  from "react-dom";
import axios from "axios";

class Evolution_tasks extends React.Component{

    constructor(props){
        super(props)

        this.user = this.props.user;

        this.tasks = {
            total: [],
            done:[],
            undone:[],
        }

        this.months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        this.state = {
            loading : true
        }
    }

    render()
    {
        if (this.state.loading) {
            return(
                <div className="animated fadeIn">
                    <div className="spiner-example">   
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>

                    <p className="text-center">Cargando...</p>
                </div>
            );
        }
        return(
            <div className="animated fadeIn">
                <canvas  id="task_evolution" width={'100%'} ></canvas>
            </div>
            
        )
    }


    componentDidMount(){
        axios.post('/dashboard/evolutionTasks', {user_id: this.user.id}).then( (response) => {
            
            this.tasks = {
                total: Object.values(response.data.tasks),
                done: Object.values(response.data.done),
                undone: Object.values(response.data.undone),
            }

            this.setState({loading: false});
        } ).then( () => {

            let ctx = document.getElementById('task_evolution').getContext('2d');

            const config = {
                type: 'bar',
                
                data:{
                    labels: this.months,

                    datasets:[

                        {
                            label:  'Tareas Realizadas',
                            data: this.tasks.done,
                            fill: false,
                            borderColor: '#1AB394',
                            backgroundColor: '#1AB394',
                            tension: 0.2,
                            
                        },

                        {
                            label:  'Tareas Pendientes',
                            data: this.tasks.undone,
                            fill: false,
                            borderColor: '#ed5565',
                            backgroundColor: '#ed5565',
                            tension: 0.2,
                            
                        }
                    ],
                },

                options: {
                    responsive: true,

                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },


                    plugins: {
                        legend: {
                            position: 'top',
                        },

                        
                    },
            
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },

                    scales: {

                        xAxes: [{
                            stacked: true
                        }],


                        yAxes:[{
                            display: true,
                            stacked: true,

                            ticks: {
                                beginAtZero:true,
                                suggestedMin: 0,
                                suggestedMax: 5,
                                userCallback: function(label, index, labels) {
                                    // when the floored value is the same as the value we have a whole number
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }
               
                                },
                            }
                           
                        }],


                    }



                }
            }

            var chart = new Chart(ctx, config);


        } )
    }

}

export default Evolution_tasks;

if (document.getElementsByTagName('evolutionTasks-chart').length >=1) {
    
    let component = document.getElementsByTagName('evolutionTasks-chart')[0];
    let user = JSON.parse(component.getAttribute('user'));
    

    ReactDOM.render(<Evolution_tasks user={user} />, component);
}