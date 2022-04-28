import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";
import Message from "./Message";

class Chat extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            loading: true,
            sending: true,
            messages: [],
        };

        this.user = this.props.user;
        this.team = this.props.team;
    }

    render() {
        if (this.state.loading == true) {
            return (
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

        return (
            <div>
                <div className="container py-2">
                    {this.state.messages.map((message, index) => {
                        return (
                            <Message
                                key={message.message + " " + index}
                                user={message.user}
                                value={message.value}
                                sended={message.sended}
                                is_mine={message.is_mine}
                                date={message.date}
                                team={message.team}
                            />
                        );
                    })}
                </div>

                <div className="container-fluid mt-5 py-2 bg-light rounded border">
                    <div className="row mx-md-5">
                        <div className="col-md-10">
                            <textarea
                                style={{ resize: "none" }}
                                className="form-control"
                                name="message"
                                id="message"
                                rows="1"
                                placeholder="Mensaje..."
                                onInput={(event) => {
                                    this.textAreaAdjust(event);
                                }}
                            ></textarea>
                        </div>

                        <div className="col-md-2 mt-md-0 mt-4 text-md-left text-center">
                            <div className="btn-group my-auto">
                                <button
                                    className="btn btn-link px-md-3 px-5"
                                    onClick={(e) => {
                                        e.preventDefault();
                                        this.sendMessage();
                                    }}
                                >
                                    <i className="fa-solid fa-paper-plane"></i>{" "}
                                </button>

                                <button className="btn btn-link px-md-3 px-5">
                                    <i className="fa-solid fa-face-smile"></i>
                                </button>

                                <button className="btn btn-link px-md-3 px-5">
                                    <i className="fa-solid fa-paperclip"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    componentDidMount() {
        //1) GET MESSAGES
        axios
            .post("/teams/get/messages", { team: this.team.id })
            .then((response) => {
                var messages = response.data.messages;

                var array_messages = [];

                messages.map((message) => {
                    let date = new Date(message.created_at);
                    date =
                        date.getDate() +
                        "/" +
                        (date.getMonth() + 1) +
                        "/" +
                        date.getFullYear() +
                        " " +
                        date.getHours() +
                        ":" +
                        date.getMinutes();

                    if (message.user.id == this.user.id) {
                        var messageObj = {
                            user: message.user,
                            value: message.value,
                            sended: true,
                            is_mine: true,
                            date: date,
                            team: this.team,
                        };
                    } else {
                        var messageObj = {
                            user: message.user,
                            value: message.value,
                            sended: true,
                            is_mine: false,
                            date: date,
                            team: this.team,
                        };
                    }

                    array_messages.push(messageObj);
                });

                this.setState({
                    messages: array_messages,
                    loading: false,
                });
            });
        //2) CHECK NEW MESSAGES
        const handleCheckMessages = (team) => {
            this.checkMessages(team);
        };

        var team = this.team;
        //DESCOMENTAR ESTA PARTE PARA AÑADIR UN COMPROBADOR AUTOMATICO
        setInterval(() => {
            handleCheckMessages(team);
        }, 500);
    }

    textAreaAdjust(event) {
        let element = event.target;
        element.style.height = "1px";
        element.style.height = 1.5 + element.scrollHeight + "px";
    }

    sendMessage() {
        //1) GET DATA
        let message = $("#message").val();

        var date = new Date();
        date =
            date.getDate() +
            "/" +
            (date.getMonth() + 1) +
            "/" +
            date.getFullYear() +
            " " +
            date.getHours() +
            ":" +
            date.getMinutes();

        if (message != null && message != "" && message != undefined) {
            //2) CLEAN TEXTAREA
            $("#message").val(null); //clean value
            let textarea = document.getElementById("message"); //get textarea
            textarea.style.height = "35.58px"; //resize textarea

            //3) CREATE MESSAJE OBJECT
            let messageObj = {
                user: this.user,
                value: message,
                sended: false,
                is_mine: true,
                date: date,
                team: this.team,
            };

            let messages = this.state.messages;
            messages.push(messageObj);

            this.setState({
                messages: messages,
            });
        }
    }

    checkMessages(team) {
        if (this.state.loading == false) {
            axios
                .post("/teams/get/messages", { team: team.id })
                .then((response) => {
                    var messages = response.data.messages;

                    var array_messages = [];

                    messages.map((message) => {
                        let date = new Date(message.created_at);
                        date =
                            date.getDate() +
                            "/" +
                            (date.getMonth() + 1) +
                            "/" +
                            date.getFullYear() +
                            " " +
                            date.getHours() +
                            ":" +
                            date.getMinutes();

                        if (message.user.id == this.user.id) {
                            var messageObj = {
                                user: message.user,
                                value: message.value,
                                sended: true,
                                is_mine: true,
                                date: date,
                                team: this.team,
                            };
                        } else {
                            var messageObj = {
                                user: message.user,
                                value: message.value,
                                sended: true,
                                is_mine: false,
                                date: date,
                                team: this.team,
                            };
                        }

                        array_messages.push(messageObj);
                    });

                    if (this.state.messages != array_messages) {
                        this.setState({
                            messages: array_messages,
                        });
                    }
                });
        }
    }
}

export default Chat;

if (document.getElementsByTagName("chat").length >= 1) {
    let component = document.getElementsByTagName("chat")[0];
    let user = JSON.parse(component.getAttribute("user"));
    let team = JSON.parse(component.getAttribute("team"));

    ReactDOM.render(<Chat user={user} team={team} />, component);
}
