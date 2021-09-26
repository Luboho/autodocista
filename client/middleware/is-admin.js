export default function({ redirect, store }) {
    const isAdmin = store.state.auth.user.is_admin;
    if (isAdmin !== "1") {
        return redirect('/auth/login')
    }
}