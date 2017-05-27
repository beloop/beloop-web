import React, { Component } from 'react';
import { createValue } from 'react-forms';

import { CustomField, CustomFieldSet } from 'Forms/base/BaseForm';

export default class CourseForm extends Component {
  constructor(props) {
    super(props);

    const formValue = createValue({
      value: props.value,
      onChange: this.onChange.bind(this),
    });
    this.state = { formValue };
  }

  onChange(formValue) {
    this.setState({ formValue });
  }

  render() {
    return (
      <CustomFieldSet formValue={this.state.formValue}>
        <CustomField select="code" label="Code" />
        <CustomField select="name" label="Name" />
      </CustomFieldSet>
    );
  }
}
