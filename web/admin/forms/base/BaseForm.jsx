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
    this.submit = this.submit.bind(this);
    this.cancel = this.cancel.bind(this);
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
    if (this.props.onSubmit) {
      this.props.onSubmit();
      return;
    }

    throw new Error('Implement submit method on child forms!');
  }

  cancel() {
    if (this.props.onCancel) {
      this.props.onCancel();
      return;
    }

    throw new Error('Implement cancel method on child forms!');
  }

  render() {
    throw new Error('Implement render method on child forms!');
  }
}
