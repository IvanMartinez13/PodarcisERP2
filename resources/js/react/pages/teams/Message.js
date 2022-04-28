import axios from "axios";
import React from "react";

class Message extends React.Component {
    constructor(props) {
        super(props);

        this.value = this.props.value;
        this.user = this.props.user;
        this.is_mine = this.props.is_mine;
        this.date = this.props.date;
        this.team = this.props.team;
        this.state = {
            sended: this.props.sended,
        };
    }

    render() {
        //RIGHT
        if (this.is_mine) {
            return (
                <div className="d-block mt-3">
                    <div className="text-left d-flex">
                        <div className="ml-auto px-2 rounded bg-primary">
                            <div className="my-auto py-1">
                                <p>
                                    {this.date} <br></br>
                                    {this.value}
                                </p>
                            </div>
                        </div>

                        {this.state.sended ? (
                            <small className="mt-auto ml-2">
                                <i
                                    className="fa fa-check"
                                    aria-hidden="true"
                                ></i>{" "}
                                Enviado
                            </small>
                        ) : (
                            <small className="mt-auto ml-2">
                                <i className="fas fa-clock"></i> Enviando
                            </small>
                        )}
                    </div>

                    <div className="text-left d-flex"></div>
                </div>
            );
        }

        //LEFT
        return (
            <div className="d-block mt-3">
                <div className="row">
                    <div className="col-lg-1 col-3">
                        <img
                            src={"/storage" + this.user.profile_photo}
                            className="img-fluid rounded-circle"
                        ></img>
                    </div>

                    <div className="col-lg-11 col-9">
                        <div className="text-left d-flex">
                            <div className="mr-auto px-2 rounded bg-light border">
                                <div className="my-auto py-1">
                                    <p>
                                        <strong>{this.user.name}</strong>
                                        {"  "}
                                        {this.date} <br></br>
                                        {this.value} <br></br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="text-left d-flex"></div>
            </div>
        );
    }

    componentDidMount() {
        if (!this.state.sended) {
            //SEND
            var message = {
                date: this.date,
                value: this.value,
                team_id: this.team.id,
                user_id: this.user.id,
            };
            axios.post("/teams/send/message", message).then((response) => {
                if (response.data.status == "success") {
                    this.setState({
                        sended: true,
                    });
                } else {
                    toastr.error(response.data.message);
                }
            });
        }
    }
}

export default Message;
