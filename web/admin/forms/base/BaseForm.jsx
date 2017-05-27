import React from 'react';
import { Input, Field as BaseField, Fieldset } from 'react-forms';
import { style } from 'react-stylesheet';

export function Label({ label }) {
  return <label className="col-sm-2 control-label">{label}</label>;
}

export function Root({ children }) {
  return <div className="form-group">{children}</div>;
}

export function InputWrapper({ children }) {
  return <div className="col-sm-10">{children}</div>;
}

export function CustomInput(props) {
  return <Input {...props} className="form-control" />;
}

export function CustomField(props) {
  return <Field {...props} Input={CustomInput} />;
}

export function CustomFieldSet(props) {
  return <Fieldset {...props} className="form-horizontal" />;
}

export const Field = style(BaseField, {
  InputWrapper,
  Label,
  Root,
});
