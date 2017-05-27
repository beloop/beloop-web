import React, { Component } from 'react';

export * from './BaseFields';

export default class BaseForm extends Component {
  constructor(props) {
    super(props);

    this.state = {
      value: props.value,
      canSubmit: false
    };

    this.enableButton = this.enableButton.bind(this);
    this.disableButton = this.disableButton.bind(this);
  }

  enableButton() {
    this.setState({
      canSubmit: true
    });
  }

  disableButton() {
    this.setState({
      canSubmit: false
    });
  }

  submit(model) {
    throw new Error('Implement submit method on child forms!');
  }

  render() {
    throw new Error('Implement render method on child forms!');
  }
}
