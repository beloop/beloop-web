import React, { Component } from 'react';

import BaseForm, { Input, TextArea } from 'Forms/base/BaseForm';

export default class CourseForm extends BaseForm {
  constructor(props) {
    super(props);
  }

  submit(model) {
    console.log(model);
  }

  render() {
    return (
      <Formsy.Form role="form" autoComplete="off" className="form-horizontal" onValid={this.enableButton} onInvalid={this.disableButton} onValidSubmit={this.submit}>
        <Input name="code" label="Code" value={this.state.value.code} required />
        <Input name="name" label="Name" value={this.state.value.name} required />
        <TextArea name="description" label="Description" value={this.state.value.description} />
        <div className="spacer text-right">
            <button type="submit" className="btn btn-space btn-primary" disabled={!this.state.canSubmit}>Submit</button>
            <a href="https://learn.deliciousyetbeautiful.com/admin/course/list" className="btn btn-space btn-default">Cancel</a>
        </div>
      </Formsy.Form>
    );
  }
}
