import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import IPHelper from "@hipanel-module-hosting/helper/IPHelper";
import IPForm from "@hipanel-module-hosting/page/IPForm";
import IP from "@hipanel-module-hosting/model/IP";

const ip: IP = {
  ip: '127.3.0.10',
  linkDevice: 'DSTEST02',
};

test("Create IP @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const ipHelper = new IPHelper(adminPage);
  const ipForm = new IPForm(adminPage);

  await ipHelper.gotoIndexIP();
  await ipHelper.gotoCreateIP();

  await ipForm.fill(ip);
  await ipForm.save();

  await ipForm.seeSuccessIPCreatingAlert();
});
