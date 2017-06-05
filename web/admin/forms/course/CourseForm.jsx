import React from 'react';
import Formsy from 'formsy-react';

import BaseForm, { Checkbox, Hidden, Input, Select, TextArea } from 'Forms/base/BaseForm';

export default class CourseForm extends BaseForm {
  constructor(props) {
    super(props);

    this.languages = [
      {
        value: 'es',
        label: 'Español',
      },
      {
        value: 'en',
        label: 'English',
      },
    ];
  }

  render() {
    return (
      <Formsy.Form role="form" autoComplete="off" className="form-horizontal" onValid={this.enableButton} onInvalid={this.disableButton} onValidSubmit={this.submit}>
        <Hidden name="id" value={this.state.value.id} />
        <Input name="code" label="Code" value={this.state.value.code} required />
        <Input name="name" label="Name" value={this.state.value.name} required />
        <TextArea name="description" label="Description" value={this.state.value.description} />
        <Input name="imageFile" label="Image" value={this.state.value.imageFile} />
        <Select name="language" label="Language" value={this.state.value.language} options={this.languages} required />
        <Checkbox name="enabled" label="Enabled" value={this.state.value.enabled} required />
        <Checkbox name="demo" label="Demo" value={this.state.value.demo} required />
        <div className="spacer text-right">
          <button type="submit" className="btn btn-space btn-primary" disabled={!this.state.canSubmit}>Submit</button>
          <button type="button" className="btn btn-space btn-default" onClick={this.cancel}>Cancel</button>
        </div>
      </Formsy.Form>
    );
  }
}
