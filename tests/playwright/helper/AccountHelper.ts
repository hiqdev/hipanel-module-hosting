import { expect, Locator, Page } from "@playwright/test";
import Input from "@hipanel-core/input/Input";
import Index from "@hipanel-core/page/Index";
import Alert from "@hipanel-core/ui/Alert";

export default class AccountHelper {
    private page: Page;
    private index: Index;

    public constructor(page: Page) {
        this.page = page;
        this.index = new Index(page);
    }

    async gotoIndexAccount() {
        await this.page.goto('/hosting/account/index');
        await expect(this.page).toHaveTitle("Accounts");
    }

    async gotoCreateAccount() {
        await this.page.locator('#dropdownMenu1').click();
        await this.page.locator('text=Create account >> nth=1').click();
    }

    async gotoAccountPage(account: string) {
        await this.index.clickLinkOnTable('Account', account);
    }

    async confirmEnableBlock() {
        await Input.field(this.page, 'textarea[name="comment"]').fill("Test enable comment");
        await this.index.clickButton('Enable block');
    }

    async confirmDisableBlock() {
        await Input.field(this.page, 'textarea[name="comment"]').fill("Test disable comment");
        await this.index.clickButton('Disable block');
    }

    async confirmDelete() {
        await this.index.clickButton('Delete');
    }

    async saveMailSettings(maximumLetters: string) {
        await Input.field(this.page, '#accountvalues-per_hour_limit').fill(maximumLetters);
        await this.index.clickButton('Save');
    }

    async saveAllowedIps(account, allowedIps: string) {
        const accountId = await this.index.getParameterFromCurrentUrl('id');
        await Input.field(this.page, `#account-${accountId}-sshftp_ips`).fill(allowedIps);
        await this.index.clickButton('Save');
    }

    async saveSystemSettings(systemSettings) {
        const accountId = await this.index.getParameterFromCurrentUrl('id');
        await Input.field(this.page, `#account-${accountId}-gid`).fill(systemSettings.group);
        await Input.field(this.page, `#account-${accountId}-uid`).fill(systemSettings.id);
        await this.index.clickButton('Save');
    }

    async saveNewPassword(newPassword) {
        const accountId = await this.index.getParameterFromCurrentUrl('id');
        await Input.field(this.page, `#account-${accountId}-password`).fill(newPassword);
        await this.index.clickButton('Save');
    }

    async seeSuccessAlert(message: string) {
        await Alert.on(this.page).hasText(message);
    }

    async seeAccountStatus(account: string, status: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue('Account', account);
        const accountStatus = await this.index.seeTextOnTable('Status', rowNumber, status);
    }
}
